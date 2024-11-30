<div id="left-sidebar" class="sidebar ">
    <h5 class="brand-name"><?php echo $site_name; ?> <a href="javascript:void(0)" class="menu_option float-right">
            <i class="icon-grid font-16 fa-brands fa-windows" data-toggle="tooltip" data-placement="left"
                title="Grid & List Toggle"></i>
        </a></h5>
    <nav id="left-sidebar-nav" class="sidebar-nav">
        <ul class="metismenu">
            <li class="g_heading">Project</li>
            <li class="<?php echo $current_page == 'index.php' ? 'active' : ''; ?>">
                <a href="index.php"><i class="fa fa-dashboard"></i><span>Dashboard</span></a>
            </li>
            <li class="g_heading">Product</li>
            <li
                class="<?php echo in_array($current_page, ['product_category.php', 'product_sub_category.php', 'specification_list.php', 'product.php', 'specification_details.php']) ? 'active' : ''; ?>">
                <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="fa-solid fa-list"></i><span>Product
                        Catalog</span></a>
                <ul>
                    <li class="<?php echo $current_page == 'product_category.php' ? 'active' : ''; ?>"><a
                            href="product_category.php">  <span class="<?php echo $current_page == 'product_category.php' ? 'mx-3' : ''; ?>">Product Categories</span></a></li>
                    <li class="<?php echo $current_page == 'product_sub_category.php' ? 'active' : ''; ?>"><a
                            href="product_sub_category.php"><span class="<?php echo $current_page == 'product_sub_category.php' ? 'mx-3' : ''; ?>">Product Sub categories</span></a></li>
                            <li class="<?php echo $current_page == 'product.php' ? 'active' : ''; ?>"><a
                            href="product.php"><span class="<?php echo $current_page == 'product.php' ? 'mx-3' : ''; ?>">Products</span></a></li>
                    <li class="<?php echo $current_page == 'specification_list.php' ? 'active' : ''; ?>"><a
                            href="specification_list.php"><span class="<?php echo $current_page == 'specification_list.php' ? 'mx-3' : ''; ?>">Specification list</span></a></li>
                    <li class="<?php echo $current_page == 'specification_details.php' ? 'active' : ''; ?>"><a href="specification_details.php"><span class="<?php echo $current_page == 'specification_details.php' ? 'mx-3' : ''; ?>">Specification details</span></a></li>                   
                </ul>
            </li>
            <li class="<?php echo $current_page == 'app-setting.php' ? 'active' : ''; ?>">
                <a href="app-setting.php"><i class="fa-solid fa-gear"></i><span>Setting</span></a>
            </li>
            <li class="g_heading">Logout</li>
            <li class="<?php echo $current_page == 'logout.php' ? 'active' : ''; ?>">
                <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i><span>Logout</span></a>
            </li>

            <!-- <li><a href="javascript:void(0)"><i class="fa fa-tag"></i><span>ContactUs</span></a></li> -->
        </ul>
    </nav>
</div>