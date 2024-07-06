<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo e(asset('images/face1.png')); ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?php echo e(auth()->user()->getFullname()); ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item has-treeview">
                    <a href="<?php echo e(route('home')); ?>" class="nav-link">
                        <i class="nav-icon fas fa-home text-info"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item drop-down">
                    <a href="#" class="nav-link <?php echo e(activeSegment('cart')); ?>">
                        <i class="nav-icon fas fa-sack-dollar text-info"></i>
                        <p>
                            Sales
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul id="salesDropdown" class="nav nav-treeview customer">
                        <li class="nav-item has-treeview">
                            <a href="<?php echo e(route('cart.index')); ?>" class="nav-link <?php echo e(activeSegment('cart')); ?>">
                                <i class="nav-icon text-xs fa-sharp fa-solid fa-store"></i>
                                <p>POS</p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="<?php echo e(route('orders.index')); ?>" class="nav-link <?php echo e(activeSegment('orders')); ?>">
                                <i class="nav-icon fas fa-cubes text-xs"></i>
                                <p>View Sales</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!--  -->
                <li class="nav-item drop-down">
                    <a href="#" class="nav-link <?php echo e(activeSegment('Purchase')); ?>">
                    <i class="nav-icon fa-sharp fa-solid fa-cubes-stacked text-info"></i>
                        <p>
                           Products
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul id="optionsDropdown" class="nav nav-treeview customer">
                        <li class="nav-item has-treeview">
                            <a href="<?php echo e(route('products.index')); ?>" class="nav-link <?php echo e(activeSegment('products')); ?>">
                                <i class="nav-icon fas fa-cubes text-sm"></i>
                                <p>All Products</p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="<?php echo e(route('products.create')); ?>" class="nav-link <?php echo e(activeSegment('allProducts')); ?>">
                                <i class="nav-icon fas fa-plus text-sm"></i>
                                <p>New Product</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item drop-down">
                    <a href="#" class="nav-link <?php echo e(activeSegment('Purchase')); ?>">
                    <i class="nav-icon fas fa-cart-plus  text-info"></i>
                        <p>
                           Purchase
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul id="optionsDropdown" class="nav nav-treeview customer">
                        <li class="nav-item has-treeview">
                            <a href="<?php echo e(route('purchase.index')); ?>" class="nav-link <?php echo e(activeSegment('purchaseList')); ?>">
                                <i class="nav-icon fa-solid fa-list-check text-xs"></i>
                                <p>Purchase List</p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="<?php echo e(route('purchase.quickPurchase')); ?>" class="nav-link <?php echo e(activeSegment('addPurchase')); ?>">
                                <i class="nav-icon fas fa-regular fa-cart-plus text-xs"></i>
                                <p>New Purchase</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item drop-down">
                    <a href="#" class="nav-link <?php echo e(activeSegment('manageOption')); ?>">
                        <i class="nav-icon text-info fa-solid fa-layer-group"></i>
                        <p>
                            Categories
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul id="optionsDropdown" class="nav nav-treeview customer">
                        <li class="nav-item has-treeview">
                            <a href="<?php echo e(route('categories.add')); ?>" class="nav-link <?php echo e(activeSegment('options')); ?>">
                            <i class="fa-sharp fa-solid fa-plus nav-icon text-xs"></i>
                                <p>Add Category</p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="<?php echo e(route('categories.manage')); ?>" class="nav-link <?php echo e(activeSegment('manage_category')); ?>">
                            <i class="nav-icon text-xs fa-regular fa-list-ul"></i>
                                <p>All Categoires</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!--  -->

                <li class="nav-item drop-down">
                    <a href="#" class="nav-link <?php echo e(activeSegment('addContacts')); ?>">
                        <i class="nav-icon fas fa-users text-info"></i>
                        <p>
                            Add Contacts
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul id="optionsDropdown" class="nav nav-treeview customer">
                        <li class="nav-item has-treeview">
                            <a href="<?php echo e(route('customers.index')); ?>" class="nav-link <?php echo e(activeSegment('customers')); ?>">
                            <i class="nav-icon text-xs fa-solid fa-address-card"></i>
                                <p>Manage Customers</p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="<?php echo e(route('viewSuppliers')); ?>" class="nav-link <?php echo e(activeSegment('suppliers')); ?>">
                            <i class=" nav-icon text-xs fa-solid fa-address-card"></i>
                                <p>Manage Suppliers</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item drop-down">
                    <a href="#" class="nav-link <?php echo e(activeSegment('expense')); ?>">
                    <i class="nav-icon fas fa-paste  text-info"></i>
                        <p>
                           Expenses
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul id="optionsDropdown" class="nav nav-treeview customer">
                        <li class="nav-item has-treeview">
                            <a href="<?php echo e(route('expense.index')); ?>" class="nav-link <?php echo e(activeSegment('expenseList')); ?>">
                                <i class="nav-icon fa-solid fa-list-check text-xs"></i>
                                <p>Expense List</p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="<?php echo e(route('expense.create')); ?>" class="nav-link <?php echo e(activeSegment('addexpense')); ?>">
                                <i class="nav-icon fas fa-regular fa-plus text-xs"></i>
                                <p>Add expenses</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item drop-down">
                    <a href="#" class="nav-link <?php echo e(activeSegment('report')); ?>">
                        <i class="nav-icon fas fa-right-left text-info"></i>
                        <p>
                            Reports
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul id="reportDropdown" class="nav nav-treeview customer">
                        <li class="nav-item has-treeview">
                            <a href="<?php echo e(route('report.index')); ?>" class="nav-link <?php echo e(activeSegment('sales_report')); ?>">
                                <i class="nav-icon fas fa-list text-xs"></i>
                                <p>Sales Report</p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="<?php echo e(route('report.expenses')); ?>" class="nav-link <?php echo e(activeSegment('expenses')); ?>">
                                <i class="nav-icon fas fa-list text-xs"></i>
                                <p>Expenses Report</p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="<?php echo e(route('report.profitLoss')); ?>" class="nav-link <?php echo e(activeSegment('profit')); ?>">
                                <i class="nav-icon fas fa-list text-xs"></i>
                                <p>Profit & Loss Report</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="<?php echo e(route('settings.index')); ?>" class="nav-link <?php echo e(activeSegment('settings')); ?>">
                        <i class="nav-icon fas fa-cogs text-info"></i>
                        <p>Settings</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="document.getElementById('logout-form').submit()">
                        <i class="nav-icon fas fa-sign-out-alt text-info"></i>
                        <p>Logout</p>
                        <form action="<?php echo e(route('logout')); ?>" method="POST" id="logout-form">
                            <?php echo csrf_field(); ?>
                        </form>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<!-- Place this script at the end of your HTML, just before the closing </body> tag --><?php /**PATH C:\xampp\htdocs\Alkhyber_POS\resources\views/layouts/partials/sidebar.blade.php ENDPATH**/ ?>