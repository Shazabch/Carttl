 <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
     <!--begin::Menu Container-->
     <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1"
         data-menu-dropdown-timeout="500">
         <!--begin::Menu Nav-->
         <ul class="menu-nav">
             <li class="menu-item " aria-haspopup="true">
                 <a href="{{ route('admin.dashboard') }}" class="menu-link">
                     <span class="svg-icon menu-icon">
                         <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Layers.svg-->
                         <i class="fas fa-tachometer-alt"></i>

                         <!--end::Svg Icon-->
                     </span>
                     <span class="menu-text">Dashboard</span>
                 </a>
             </li>
             <li class="menu-section">
                 <h4 class="menu-text">Enquiries</h4>
                 <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
             </li>

             <li class="menu-item menu-item-submenu  }}" aria-haspopup="true" data-menu-toggle="hover">
                 <a href="javascript:;" class="menu-link menu-toggle">
                     <span class="svg-icon menu-icon">
                         <i class="fas fa-envelope-open-text"></i>
                     </span>
                     <span class="menu-text">Enquiry Management</span>
                     <i class="menu-arrow"></i>
                 </a>

                 <!-- Submenu Start -->
                 <div class="menu-submenu">
                     <i class="menu-arrow"></i>
                     <ul class="menu-subnav">

                         <!-- Sale Management Link -->
                         <li class="menu-item " aria-haspopup="true">
                             <a href="{{ route('admin.submissions') }}" class="menu-link">
                                 <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                 <span class="menu-text">Contact Enquiries</span>
                             </a>
                         </li>

                         <!-- Direct Income Link -->
                         <li class="menu-item " aria-haspopup="true">
                             <a href="{{ route('admin.inspection.enquiries') }}" class="menu-link">
                                 <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                 <span class="menu-text">Inspection Enquiries</span>
                             </a>
                         </li>

                         <li class="menu-item " aria-haspopup="true">
                             <a href="{{ route('admin.purchase.list') }}" class="menu-link">
                                 <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                 <span class="menu-text">Purchase Enquiries</span>
                             </a>
                         </li>

                         <li class="menu-item " aria-haspopup="true">
                             <a href="{{ route('admin.sell.list') }}" class="menu-link">
                                 <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                 <span class="menu-text">Sell Enquiries</span>
                             </a>
                         </li>

                     </ul>
                 </div>
                 <!-- Submenu End -->
             </li>

             <li class="menu-section">
                 <h4 class="menu-text">Vehicles</h4>
                 <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
             </li>

             <li class="menu-item menu-item-submenu  }}" aria-haspopup="true" data-menu-toggle="hover">
                 <a href="javascript:;" class="menu-link menu-toggle">
                     <span class="svg-icon menu-icon">
                         <i class="fas fa-car"></i>
                     </span>
                     <span class="menu-text">Vehicle Inspection</span>
                     <i class="menu-arrow"></i>
                 </a>

                 <!-- Submenu Start -->
                 <div class="menu-submenu">
                     <i class="menu-arrow"></i>
                     <ul class="menu-subnav">

                         <!-- Sale Management Link -->
                         <li class="menu-item " aria-haspopup="true">
                             <a href="{{ route('admin.inspection.generate') }}" class="menu-link">
                                 <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                 <span class="menu-text">Inspect</span>
                             </a>
                         </li>



                     </ul>
                 </div>
                 <!-- Submenu End -->
             </li>


             <li class="menu-item menu-item-submenu  }}" aria-haspopup="true" data-menu-toggle="hover">
                 <a href="javascript:;" class="menu-link menu-toggle">
                     <span class="svg-icon menu-icon">
                         <i class="fas fa-car"></i>
                     </span>
                     <span class="menu-text">Vehicle Management</span>
                     <i class="menu-arrow"></i>
                 </a>

                 <!-- Submenu Start -->
                 <div class="menu-submenu">
                     <i class="menu-arrow"></i>
                     <ul class="menu-subnav">

                         <!-- Sale Management Link -->
                         <li class="menu-item " aria-haspopup="true">
                             <a href="{{ route('admin.vehicles','add') }}" class="menu-link">
                                 <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                 <span class="menu-text">Add Vehicle</span>
                             </a>
                         </li>
                         <li class="menu-item " aria-haspopup="true">
                             <a href="{{ route('admin.vehicles','all') }}" class="menu-link">
                                 <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                 <span class="menu-text">All Vehicles</span>
                             </a>
                         </li>
                         <li class="menu-item " aria-haspopup="true">
                             <a href="{{ route('admin.vehicles','listed') }}" class="menu-link">
                                 <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                 <span class="menu-text">Listed Vehicles</span>
                             </a>
                         </li>
                         <li class="menu-item " aria-haspopup="true">
                             <a href="{{ route('admin.vehicles','pending') }}" class="menu-link">
                                 <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                 <span class="menu-text">Pending Vehicles</span>
                             </a>
                         </li>
                         <li class="menu-item " aria-haspopup="true">
                             <a href="{{ route('admin.vehicles','sold') }}" class="menu-link">
                                 <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                 <span class="menu-text">Sold Vehicles</span>
                             </a>
                         </li>
                         <li class="menu-item " aria-haspopup="true">
                             <a href="{{ route('admin.submissions') }}" class="menu-link">
                                 <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                 <span class="menu-text">All Vehicle Enquiries</span>
                             </a>
                         </li>
                     </ul>
                 </div>
                 <!-- Submenu End -->
             </li>
             {{--
             <li class="menu-section">
                 <h4 class="menu-text">Sell</h4>
                 <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
             </li>
             <li class="menu-item menu-item-submenu " aria-haspopup="true" data-menu-toggle="hover">
                 <a href="javascript:;" class="menu-link menu-toggle">
                     <span class="svg-icon menu-icon">
                         <i class="fas fa-cogs"></i>
                     </span>
                     <span class="menu-text">Sell</span>
                     <i class="menu-arrow"></i>
                 </a>




                 <!-- Submenu Start -->
                 <div class="menu-submenu">
                     <i class="menu-arrow"></i>
                     <ul class="menu-subnav">

                         <!-- Sale Management Link -->
                         <li class="menu-item " aria-haspopup="true">
                             <a href="{{ route('admin.sell.index') }}" class="menu-link">
             <i class="menu-bullet menu-bullet-dot"><span></span></i>
             <span class="menu-text">Sell Your Car</span>
             </a>
             </li>

         </ul>
     </div>
     --}}
     <!-- Submenu End -->
     </li>




     <li class="menu-section">
         <h4 class="menu-text">Administrator</h4>
         <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
     </li>

     <li class="menu-item menu-item-submenu  }}" aria-haspopup="true" data-menu-toggle="hover">
         <a href="javascript:;" class="menu-link menu-toggle">
             <span class="svg-icon menu-icon">
                 <i class="fas fa-cogs"></i>
             </span>
             <span class="menu-text">System Settings</span>
             <i class="menu-arrow"></i>
         </a>

         <!-- Submenu Start -->
         <div class="menu-submenu">
             <i class="menu-arrow"></i>
             <ul class="menu-subnav">

                 <!-- Sale Management Link -->
                 <li class="menu-item " aria-haspopup="true">
                     <a href="{{ route('admin.roles') }}" class="menu-link">
                         <i class="menu-bullet menu-bullet-dot"><span></span></i>
                         <span class="menu-text">Roles</span>
                     </a>
                 </li>
                 <li class="menu-item " aria-haspopup="true">
                     <a href="{{ route('admin.user') }}" class="menu-link">
                         <i class="menu-bullet menu-bullet-dot"><span></span></i>
                         <span class="menu-text">Users</span>
                     </a>
                 </li>
                 <li class="menu-item " aria-haspopup="true">
                     <a href="{{ route('admin.blogs') }}" class="menu-link">
                         <i class="menu-bullet menu-bullet-dot"><span></span></i>
                         <span class="menu-text">Blogs</span>
                     </a>
                 </li>
                 <li class="menu-item " aria-haspopup="true">
                     <a href="{{ route('admin.testimonials') }}" class="menu-link">
                         <i class="menu-bullet menu-bullet-dot"><span></span></i>
                         <span class="menu-text">Testimonials</span>
                     </a>
                 </li>


             </ul>
         </div>
         <!-- Submenu End -->
     </li>


     </ul>
     <!--end::Menu Nav-->
 </div>
 <!--end::Menu Container-->
 </div>