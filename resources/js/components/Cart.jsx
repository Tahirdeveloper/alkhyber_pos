import React, { Component } from "react";
import ReactDOM from "react-dom";
import axios from "axios";
import Swal from "sweetalert2";
import { sum } from "lodash";
import Select from 'react-select';

class Cart extends Component {
    constructor(props) {
        super(props);
        this.state = {
            cart: [],
            products: [],
            customers: [],
            barcode: "",
            search: "",
            customer_id: "",
            shorts: 0,
            discount: 0,
            kgDiscount: 0,
            pricePerKg: 0,
            kgPrice: 0,
            kg: {},
            netPrice: 0,
            grossTotal: 0,
            price: 0,
        };

        this.loadCart = this.loadCart.bind(this);
        this.handleOnChangeBarcode = this.handleOnChangeBarcode.bind(this);
        this.handleScanBarcode = this.handleScanBarcode.bind(this);
        this.handleChangeQty = this.handleChangeQty.bind(this);
        this.handleEmptyCart = this.handleEmptyCart.bind(this);

        this.loadProducts = this.loadProducts.bind(this);
        this.handleChangeSearch = this.handleChangeSearch.bind(this);
        this.handleSeach = this.handleSeach.bind(this);
        this.setCustomerId = this.setCustomerId.bind(this);
        this.handleClickSubmit = this.handleClickSubmit.bind(this);
        this.handlePayAll = this.handlePayAll.bind(this);
        this.handleShorts = this.handleShorts.bind(this);
        this.handleDiscount = this.handleDiscount.bind(this);
        this.handleKgChange = this.handleKgChange.bind(this);
        this.handlegrossTotal = this.handlegrossTotal.bind(this);
    }

    componentDidMount() {
        // load user cart
        this.loadCart();
        this.loadProducts();
        this.loadCustomers();
    }

    loadCustomers() {
        axios.get(`/admin/add/customers`).then((res) => {
            const customers = res.data;
            this.setState({ customers });
        });
    }

    loadProducts(search = "") {
        const query = !!search ? `?search=${search}` : "";
        axios.get(`/admin/purchase${query}`).then((res) => {
            const products = res.data.data;
            this.setState({ products });
        });
    }

    handleOnChangeBarcode(event) {
        const barcode = event.target.value;
        // console.log(barcode);
        this.setState({ barcode });
    }

    loadCart() {
        axios.get("/admin/cart").then((res) => {
            const cart = res.data;
            this.setState({ cart });
        });
    }

    handleScanBarcode(event) {
        event.preventDefault();
        const { barcode } = this.state;
        if (!!barcode) {
            axios
                .post("/admin/cart", { barcode })
                .then((res) => {
                    this.loadCart();
                    this.setState({ barcode: "" });
                })
                .catch((err) => {
                    Swal.fire("Error!", err.response.data.message, "error");
                });
        }
    }
    handleChangeQty(product_id, qty) {
        const { cart } = this.state;
        const updatedCart = cart.map((item) => {
            if (item.id === product_id) {
                const pricePerKg = this.state.price[product_id] || 0;
                const kg = parseFloat(item.kg);
                const shorts = this.state.shorts[product_id] || 0;
                const purchaseTotal = parseFloat(item.grossTotal) || 0;
                console.log(item.grossTotal);
                const kgDiscount = this.state.kgDiscount[product_id] || 0;
                const grossPrice = purchaseTotal * qty;
                const netPrice = pricePerKg * kg * qty - shorts * pricePerKg;
                return {
                    ...item,
                    pivot: {
                        ...item.pivot,
                        quantity: qty,
                    },
                    netPrice,
                    grossPrice,
                };
            }

            return item;
        });

        this.setState({ cart: updatedCart });

        if (!qty) return;

        axios
            .post("/admin/cart/change-qty", { product_id, quantity: qty })
            .then((res) => { })
            .catch((err) => {
                Swal.fire("Error!", err.response.data.message, "error");
            });
    }

    updateTotal(cart) {
        const total = cart.map((c) => (c.netPrice ? c.netPrice : 0));
        return sum(total);
    }
    getTotal(cart) {
        const total = cart.map((c) => (c.grossTotal / c.quantity.toFixed(2)) * c.pivot.quantity);
        console.log(total);
        return sum(total);
    }

    handleClickDelete(product_id) {
        axios
            .post("/admin/cart/delete", { product_id, _method: "DELETE" })
            .then((res) => {
                const cart = this.state.cart.filter((c) => c.id !== product_id);
                this.setState({ cart });
            });
    }
    handleEmptyCart() {
        axios.post("/admin/cart/empty", { _method: "DELETE" }).then((res) => {
            this.setState({ cart: [] });
        });
    }
    handleChangeSearch(event) {
        const search = event.target.value;
        this.setState({ search });
    }
    handleSeach(event) {
        if (event.keyCode === 13) {
            this.loadProducts(event.target.value);
        }
    }

    addProductToCart(barcode) {
        let product = this.state.products.find((p) => p.barcode === barcode);
        if (!!product) {
            let cart = this.state.cart.find((c) => c.id === product.id);
            if (!!cart) {
                this.setState({
                    cart: this.state.cart.map((c) => {
                        if (
                            c.id === product.id &&
                            product.quantity > c.pivot.quantity
                        ) {
                            c.pivot.quantity = c.pivot.quantity + 1;
                        }
                        return c;
                    }),
                });
            } else {
                if (product.quantity > 0) {
                    product = {
                        ...product,
                        pivot: {
                            quantity: 1,
                            product_id: product.id,
                            user_id: 1,
                        },
                    };

                    this.setState({ cart: [...this.state.cart, product] });
                }
            }

            axios
                .post("/admin/cart", { barcode })
                .then((res) => {
                    // this.loadCart();
                    // console.log(res);
                })
                .catch((err) => {
                    Swal.fire("Error!", err.response.data.message, "error");
                });
        }
    }

    setCustomerId(event) {
        this.setState({ customer_id: event.target.value });
    }
    handleClickSubmit() {
        Swal.fire({
            title: "Pay Amount",
            html: `
            <div class="row">
                        <div class="col">
                                <label for="amount">Amount</label>
                                <input id="amount" type="text" class="form-control" value="${this.updateTotal(
                this.state.cart
            )}">
                            </div>
                            <div class="col">
                                <label for="paymentMethod">Payment Method</label>
                                <select id="paymentMethod" class="form-control" onchange="paymentMethod()">
                                    <option value="Cash" selected>Cash</option>
                                    <option value="Check">Check</option>
                                    <option value="EasyJazz">Easypisa/Jazzcash</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-4 d-none" id="t_details">
                            <div class="col-12">
                                 <label for="check" id="label">TID/Check No</label>
                                 <input id="tid" name="tid" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col">
                                 <label for="discount" id="label">Discount</label>
                                 <input id="discount" name="discount" type="text" class="form-control" value="" placeholder="00" onchange="calculate()" />
                            </div>
                            <div class="col">
                                <label for="date">Date</label>
                                <input id="date" type="date" name="date" class="form-control" />
                            </div>
                        </div>
                        <div class="col">
                        <div class="mt-3">
                            <label for="additionalNotes">Additional Notes</label>
                            <textarea id="additionalNotes" name="notes" class="form-control"></textarea>
                        </div>
                        </div>
            `,
            showCancelButton: true,
            confirmButtonText: "Send",
            showLoaderOnConfirm: true,
            preConfirm: async () => {
                try {
                    const totalAmount = this.getTotal(this.state.cart);
                    console.log(totalAmount);

                    const grossTotal = this.updateTotal(this.state.cart);
                    const discount = parseFloat(
                        Swal.getPopup().querySelector("#discount").value
                    );
                    const paymentMethod =
                        Swal.getPopup().querySelector("#paymentMethod").value;
                    const amount = parseFloat(
                        Swal.getPopup().querySelector("#amount").value
                    );
                    const additionalNotes =
                        Swal.getPopup().querySelector("#additionalNotes").value;
                    const tid = Swal.getPopup().querySelector("#tid").value;
                    const date = Swal.getPopup().querySelector("#date").value;

                    const kgPrices = this.state.cart.map(
                        (c) => this.state.price[c.id] || 0
                    );
                    console.log(kgPrices);
                    const shorts = this.state.cart.map(
                        (c) => this.state.shorts[c.id] || 0
                    );
                    const prices = this.state.cart.map(
                        (c) => c.netPrice || 0
                    );

                    const kgs = this.state.cart.map((c) => c.kg).join(",");
                    const response = await axios.post("/admin/orders", {
                        totalAmount,
                        grossTotal: grossTotal,
                        customer_id: this.state.customer_id,
                        amount,
                        shorts: shorts,
                        prices: prices,
                        kgPrices: kgPrices,
                        kgs: kgs,
                        paymentMethod,
                        additionalNotes,
                        discount,
                        tid,
                        date,
                    });

                    if (response.data) {
                        Swal.fire({
                            icon: "success",
                            title: "Success!",
                            html: `<p>Amount paid successfully.</p>
                            <p>Total Amount: ${amount}</p>`,
                        });
                        this.loadCart();
                    } else {
                        Swal.fire("Error!", "Payment failed.", "error");
                    }
                } catch (error) {
                    Swal.fire(
                        "Error!",
                        error.response?.data?.message || "An error occurred.",
                        "error"
                    );
                }
            },
            allowOutsideClick: () => !Swal.isLoading(),
        }).then((result) => {
            if (result.value) {
                // Handle any post-submit actions here if needed
            }
        });
    }

    handlePayAll() {
        Swal.fire({
            title: "Pay Amount",
            html: `
                <div class="row">
                    <div class="col">
                        <label for="amount">Amount</label>
                        <input id="amount" type="text" class="form-control" value="${this.updateTotal(
                this.state.cart
            )}" disabled>
                    </div>
                    <div class="col">
                        <label for="paymentMethod">Payment Method</label>
                        <select id="paymentMethod" class="form-control">
                            <option value="Cash" selected>Cash</option>
                            <option value="Check">Check</option>
                            <option value="EasyJazz">Easypisa/Jazzcash</option>
                            <option value="bank_transfer">Bank Transfer</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-4" id="t_details">
                    <div class="col">
                        <label for="check" id="label">TID/Check No</label>
                        <input id="tid" name="tid" type="text" class="form-control" />
                    </div>
                    <div class="col">
                        <label for="date">Date</label>
                        <input id="date" type="date" name="date" class="form-control" required/>
                    </div>
                </div>
                <div class="col">
                    <div class="mt-3">
                        <label for="additionalNotes">Additional Notes</label>
                        <textarea id="additionalNotes" name="notes" class="form-control"></textarea>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: "Send",
            showLoaderOnConfirm: true,
            preConfirm: async () => {
                try {
                    const totalAmount = this.getTotal(this.state.cart);
                    const grossTotal = this.updateTotal(this.state.cart);
                    const paymentMethod =
                        Swal.getPopup().querySelector("#paymentMethod").value;
                    const amount = parseFloat(
                        Swal.getPopup().querySelector("#amount").value
                    );
                    const additionalNotes =
                        Swal.getPopup().querySelector("#additionalNotes").value;
                    const tid = Swal.getPopup().querySelector("#tid").value;
                    const date = Swal.getPopup().querySelector("#date").value;

                    const kgPrices = this.state.cart.map(
                        (c) => this.state.price[c.id] || 0
                    );
                    const shorts = this.state.cart.map(
                        (c) => this.state.shorts[c.id] || 0
                    );
                    const prices = this.state.cart.map(
                        (c) => c.netPrice || 0
                    );
                    const kgs = this.state.cart.map((c) => c.kg).join(", ");


                    const response = await axios.post("/admin/orders", {
                        totalAmount,
                        customer_id: this.state.customer_id,
                        amount,
                        grossTotal,
                        shorts: shorts,
                        prices: prices,
                        kgPrices: kgPrices,
                        kgs:kgs,
                        discount: 0,
                        paymentMethod,
                        additionalNotes,
                        tid,
                        date,
                    });

                    if (response.data) {
                        Swal.fire({
                            icon: "success",
                            title: "Success!",
                            html: `<p>Amount paid successfully.</p>
                            <p>Total Amount: ${amount}</p>`,
                        });
                        this.loadCart();
                    } else {
                        Swal.fire("Error!", "Payment failed.", "error");
                    }
                } catch (error) {
                    Swal.fire(
                        "Error!",
                        error.response?.data?.message,
                        "error"
                    );
                }
            },
            allowOutsideClick: () => !Swal.isLoading(),
        }).then((result) => {
            if (result.value) {
            }
        });
    }

    // Update the state when user enters the shorts for a product
    handleShorts(productId, value) {
        this.setState((prevState) => {
            const updatedShorts = {
                ...prevState.shorts,
                [productId]: parseFloat(value),
            };

            const updatedCart = prevState.cart.map((item) => {
                if (item.id === productId) {
                    const pricePerKg = this.state.price[productId] || 0;
                    const shorts = updatedShorts[productId] || 0;
                    const kgDiscount = this.state.kgDiscount[productId] || 0;
                    const kg = parseFloat(item.kg);

                    // Calculate the net price considering shorts and discount
                    const netPrice =
                        pricePerKg * item.pivot.quantity * kg -
                        (pricePerKg * shorts + kgDiscount);

                    return {
                        ...item,
                        netPrice,
                    };
                }
                return item;
            });

            return {
                shorts: updatedShorts,
                cart: updatedCart,
            };
        });
    }

    // Update the state when user enters the discount for a product
    handleDiscount(productId, value) {
        this.setState((prevState) => {
            const updatedPrice = {
                ...prevState.price,
                [productId]: parseFloat(value),
            };

            const updatedCart = prevState.cart.map((item) => {
                if (item.id === productId) {
                    const pricePerKg = parseFloat(item.price);
                    const kg = parseFloat(item.kg);
                    const shorts = this.state.shorts[productId] || 0;
                    const kgPrice = updatedPrice[productId] || 0;
                    console.log("this is handleChange" + kgPrice);
                    // Calculate the net price considering shorts and Price
                    const netPrice =
                        kgPrice * kg * item.pivot.quantity -
                        shorts * pricePerKg;

                    return {
                        ...item,
                        netPrice,
                        kgPrice
                    };
                }
                return item;
            });

            return {
                price: updatedPrice,
                cart: updatedCart,
            };
        });
    }
    handlegrossTotal(productId, value) {
        this.setState((prevState) => {
            const updatedGrossTotal = { ...prevState.grossTotal };
            if (value !== undefined) {
                updatedGrossTotal[productId] = parseFloat(value);
            } else {
                updatedGrossTotal[productId] = parseFloat(c.grossTotal);
            }
            const updatedCart = prevState.cart.map((item) => {
                if (item.id === productId) {
                    return {
                        ...item,
                        grossTotal: updatedGrossTotal[productId] || 0,
                    };
                }
                return item;
            });
            return {
                grossTotal: updatedGrossTotal,
                cart: updatedCart,
            };
        });
    }

    handleKgChange(productId, value) {
        const updatedkg = { ...this.state.kg };
        updatedkg[productId] = parseFloat(value) || 0;
        this.setState({ kg: updatedkg });
    }


    setCustomerId = (selectedOption) => {
        this.setState({ customer_id: selectedOption ? selectedOption.value : '' });
    };
    render() {
        const { cart, products, customers, barcode } = this.state;
        return (
            <div className="row w-100 pb-4">
                <div className="col-md-8 col-lg-7">
                    <div className="row mb-2">
                        <div className="col">
                            <form onSubmit={this.handleScanBarcode}>
                                <input
                                    type="text"
                                    className="form-control"
                                    placeholder="Scan Barcode..."
                                    value={barcode}
                                    onChange={this.handleOnChangeBarcode}
                                />
                            </form>
                        </div>
                        <div className="col">
                            <Select
                                className="form-control"
                                options={customers.map(cus => ({
                                    value: cus.id,
                                    label: `${cus.first_name} ${cus.last_name}`
                                }))}
                                onChange={this.setCustomerId}
                                placeholder="Select a customer"
                                value={customers.find(cus => cus.id === this.state.customer_id)}
                                menuPortalTarget={document.body}
                                styles={{ menuPortal: base => ({ ...base, zIndex: 9999 }) }}
                            />



                        </div>
                    </div>
                    <div className="user-cart">
                        <div className="card h-auto min-vh-100">
                            <table className="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th style={{ width: "135px" }}>
                                            Shorts (kg)
                                        </th>
                                        <th
                                            className="text-center"
                                            style={{ width: "160px" }}
                                        >
                                            Price/kg
                                        </th>

                                        <th
                                            className="text-center"
                                            style={{ width: "160px" }}
                                        >
                                            Kgs/Bag
                                        </th>
                                        <th className="text-center">
                                            Purchase Price/kg
                                        </th>
                                        <th className="text-right">
                                            Total Price
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {cart.map((c) => (
                                        <tr key={c.id}>
                                            <td>{c.name}</td>
                                            <td>
                                                <input
                                                    type="number"
                                                    className="form-control form-control-sm qty mx-1"
                                                    value={c.pivot.quantity}
                                                    onChange={(event) =>
                                                        this.handleChangeQty(
                                                            c.id,
                                                            event.target.value
                                                        )
                                                    }
                                                />
                                                <button
                                                    className="btn btn-danger btn-sm"
                                                    onClick={() =>
                                                        this.handleClickDelete(
                                                            c.id
                                                        )
                                                    }
                                                >
                                                    <i className="fas fa-trash"></i>
                                                </button>
                                            </td>
                                            <td className="">
                                                <input
                                                    type="number"
                                                    name="shorts[]"
                                                    onChange={(event) =>
                                                        this.handleShorts(
                                                            c.id,
                                                            event.target.value
                                                        )
                                                    }
                                                    className="w-75 text-center"
                                                    placeholder="00"
                                                    value={
                                                        this.state.shorts[
                                                            c.id
                                                        ] !== undefined
                                                            ? this.state.shorts[
                                                            c.id
                                                            ]
                                                            : 0
                                                    }
                                                />
                                            </td>
                                            <td
                                                className="text-center"
                                                id="kgPrice"
                                            >
                                                <input
                                                    className="w-75 text-center"
                                                    type="number"
                                                    name="kgPrice[]"
                                                    onChange={(event) =>
                                                        this.handleDiscount(
                                                            c.id,
                                                            event.target.value
                                                        )
                                                    }
                                                    value={
                                                        this.state.price[
                                                            c.id
                                                        ] !== undefined
                                                            ? this.state.price[
                                                            c.id
                                                            ]
                                                            : 0
                                                    }
                                                />
                                            </td>
                                            <td className="text-center">
                                                <input
                                                    type="number"
                                                    name="kgs[]"
                                                    className="text-center w-75"
                                                    onChange={(event) =>
                                                        this.handleKgChange(
                                                            c.id,
                                                            event.target.value
                                                        )
                                                    }
                                                    value={
                                                        this.state.kg[c.id] !== undefined
                                                            ? this.state.kg[c.id]
                                                            : (c.kg !== undefined ? c.kg : 0)
                                                    }
                                                />
                                            </td>
                                            <td
                                                className="text-center"
                                                id="price"
                                            >
                                                <input
                                                    name="grossTotal[]" className="text-center w-75"
                                                    type="hidden"
                                                    value={
                                                        c.grossPrice !== undefined
                                                            ? (c.grossPrice / c.quantity).toFixed(2)
                                                            : (c.grossTotal / c.quantity).toFixed(2)
                                                    }
                                                />
                                                {c.price !== undefined
                                                    ? c.price
                                                    : 0
                                                }
                                            </td>
                                            <td
                                                className="text-right"
                                                id="price"
                                            >
                                                <input
                                                    name="price[]"
                                                    type="hidden"
                                                    value={
                                                        c.netPrice !== undefined
                                                            ? c.netPrice
                                                            : 0
                                                    }
                                                />
                                                {window.APP.currency_symbol}{" "}
                                                {c.netPrice ? c.netPrice : 0}
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div className="row">
                        <div className="col">Total:</div>
                        <div className="col text-right">
                            {window.APP.currency_symbol}{" "}
                            {this.updateTotal(cart)}
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md-3">
                            <button
                                type="button"
                                className="btn btn-danger btn-block"
                                onClick={this.handleEmptyCart}
                                disabled={!cart.length}
                            >
                                Cancel
                            </button>
                        </div>
                        <div className="col-md-3">
                            <button
                                type="button"
                                className="btn btn-primary btn-block"
                                disabled={!cart.length}
                                onClick={this.handleClickSubmit}
                            >
                                Multiple pay
                            </button>
                        </div>
                        <div className="col-md-3">
                            <button
                                type="button"
                                className="btn btn-primary btn-block"
                                disabled={!cart.length}
                                onClick={this.handlePayAll}
                            >
                                Pay All
                            </button>
                        </div>
                    </div>
                </div>
                <div className="col-md-4 col-lg-5">
                    <div className="mb-2">
                        <input
                            type="text"
                            className="form-control"
                            placeholder="Search Product..."
                            onChange={this.handleChangeSearch}
                            onKeyDown={this.handleSeach}
                        />
                    </div>
                    <div className="order-product">
                        {products.map((p) => (
                            <div
                                onClick={() => this.addProductToCart(p.barcode)}
                                key={p.id}
                                className="item"
                            >
                                <img src={p.image_url} alt="" />

                                <h5
                                    style={
                                        window.APP.warning_quantity > p.quantity
                                            ? { color: "red" }
                                            : {}
                                    }
                                >
                                    {p.name}({p.quantity})
                                </h5>
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        );
    }
}

export default Cart;

if (document.getElementById("cart")) {
    ReactDOM.createRoot(document.getElementById("cart")).render(<Cart />);
}
