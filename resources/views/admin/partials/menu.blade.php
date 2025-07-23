 <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
     <!--begin::Menu Container-->
     <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1"
         data-menu-dropdown-timeout="500">
         <!--begin::Menu Nav-->
         <ul class="menu-nav">
             <li class="menu-item " aria-haspopup="true">
                 <a href="{{route('admin.dashboard')}}" class="menu-link">
                     <span class="svg-icon menu-icon">
                         <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Layers.svg-->
                         <i class="fas fa-tachometer-alt"></i>

                         <!--end::Svg Icon-->
                     </span>
                     <span class="menu-text">Dashboard</span>
                 </a>
             </li>
              <li class="menu-item" aria-haspopup="true">
                 <a href="{{ route('admin.submissions') }}" class="menu-link">
                     <span class="svg-icon menu-icon">
                         <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Layers.svg-->
                         <i class="fas fa-clipboard"></i>

                         <!--end::Svg Icon-->
                     </span>
                     <span class="menu-text">Customer Enquiries</span>
                 </a>
             </li>
             <li class="menu-section">
                 <h4 class="menu-text">System</h4>
                 <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
             </li>

             <li class="menu-item" aria-haspopup="true">
                 <a href="{{ route('car.damage.test') }}" class="menu-link">
                     <span class="svg-icon menu-icon">
                         <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Layers.svg-->
                         <i class="fas fa-car"></i>

                         <!--end::Svg Icon-->
                     </span>
                     <span class="menu-text">Car Test</span>
                 </a>
             </li>


             <li class="menu-item " aria-haspopup="true">
                 <a href="" class="menu-link">
                     <span class="svg-icon menu-icon">
                         <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Layers.svg-->
                         <i class="fas fa-user-shield"></i>

                         <!--end::Svg Icon-->
                     </span>
                     <span class="menu-text">Car 2</span>
                 </a>
             </li>








             <li class="menu-section">
                 <h4 class="menu-text">Administrator</h4>
                 <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
             </li>
             <!--Dummy-->
             <li class="menu-item menu-item-submenu  }}"
                 aria-haspopup="true" data-menu-toggle="hover">
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
                             <a href="{{route('admin.user')}}" class="menu-link">
                                 <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                 <span class="menu-text">Users</span>
                             </a>
                         </li>

                         <!-- Direct Income Link -->
                         <li class="menu-item " aria-haspopup="true">
                             <a href="#" class="menu-link">
                                 <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                 <span class="menu-text">Sale 2</span>
                             </a>
                         </li>

                     </ul>
                 </div>
                 <!-- Submenu End -->
             </li>

             <li class="menu-item menu-item-submenu  }}"
                 aria-haspopup="true" data-menu-toggle="hover">
                 <a href="javascript:;" class="menu-link menu-toggle">
                     <span class="svg-icon menu-icon">
                         <!--begin::Svg Icon-->
                         <i class="fas fa-cash-register"></i>

                         <!--end::Svg Icon-->
                     </span>
                     <span class="menu-text">Purchase</span>
                     <i class="menu-arrow"></i>
                 </a>

                 <!-- Submenu Start -->
                 <div class="menu-submenu">
                     <i class="menu-arrow"></i>
                     <ul class="menu-subnav">

                         <!-- Sale Management Link -->
                         <li class="menu-item " aria-haspopup="true">
                             <a href="#" class="menu-link">
                                 <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                 <span class="menu-text">Purchase</span>
                             </a>
                         </li>

                         <!-- Direct Income Link -->
                         <li class="menu-item " aria-haspopup="true">
                             <a href="#" class="menu-link">
                                 <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                 <span class="menu-text">Purchase 2</span>
                             </a>
                         </li>

                     </ul>
                 </div>
                 <!-- Submenu End -->
             </li>

             <!-- Side Bar End -->
             <li class="menu-item menu-item-submenu d-none" aria-haspopup="true"
                 data-menu-toggle="hover">
                 <a href="javascript:;" class="menu-link menu-toggle">
                     <span class="svg-icon menu-icon">
                         <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                         <svg xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                             viewBox="0 0 24 24" version="1.1">
                             <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                 <rect x="0" y="0" width="24" height="24" />
                                 <rect fill="#000000" x="4" y="4" width="7" height="7"
                                     rx="1.5" />
                                 <path
                                     d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z"
                                     fill="#000000" opacity="0.3" />
                             </g>
                         </svg>
                         <!--end::Svg Icon-->
                     </span>
                     <span class="menu-text">Applications</span>
                     <i class="menu-arrow"></i>
                 </a>
                 <div class="menu-submenu">
                     <i class="menu-arrow"></i>
                     <ul class="menu-subnav">
                         <li class="menu-item menu-item-parent" aria-haspopup="true">
                             <span class="menu-link">
                                 <span class="menu-text">Applications</span>
                             </span>
                         </li>
                         <li class="menu-item menu-item-submenu" aria-haspopup="true"
                             data-menu-toggle="hover">
                             <a href="javascript:;" class="menu-link menu-toggle">
                                 <i class="menu-bullet menu-bullet-line">
                                     <span></span>
                                 </i>
                                 <span class="menu-text">Users</span>
                                 <span class="menu-label">
                                     <span class="label label-rounded label-primary">6</span>
                                 </span>
                                 <i class="menu-arrow"></i>
                             </a>
                             <div class="menu-submenu">
                                 <i class="menu-arrow"></i>
                                 <ul class="menu-subnav">
                                     <li class="menu-item" aria-haspopup="true">
                                         <a href="custom/apps/user/list-default.html"
                                             class="menu-link">
                                             <i class="menu-bullet menu-bullet-dot">
                                                 <span></span>
                                             </i>
                                             <span class="menu-text">List - Default</span>
                                         </a>
                                     </li>
                                     <li class="menu-item" aria-haspopup="true">
                                         <a href="custom/apps/user/list-datatable.html"
                                             class="menu-link">
                                             <i class="menu-bullet menu-bullet-dot">
                                                 <span></span>
                                             </i>
                                             <span class="menu-text">List - Datatable</span>
                                         </a>
                                     </li>
                                     <li class="menu-item" aria-haspopup="true">
                                         <a href="custom/apps/user/list-columns-1.html"
                                             class="menu-link">
                                             <i class="menu-bullet menu-bullet-dot">
                                                 <span></span>
                                             </i>
                                             <span class="menu-text">List - Columns 1</span>
                                         </a>
                                     </li>
                                     <li class="menu-item" aria-haspopup="true">
                                         <a href="custom/apps/user/list-columns-2.html"
                                             class="menu-link">
                                             <i class="menu-bullet menu-bullet-dot">
                                                 <span></span>
                                             </i>
                                             <span class="menu-text">List - Columns 2</span>
                                         </a>
                                     </li>
                                     <li class="menu-item" aria-haspopup="true">
                                         <a href="custom/apps/user/add-user.html" class="menu-link">
                                             <i class="menu-bullet menu-bullet-dot">
                                                 <span></span>
                                             </i>
                                             <span class="menu-text">Add User</span>
                                         </a>
                                     </li>
                                     <li class="menu-item" aria-haspopup="true">
                                         <a href="custom/apps/user/edit-user.html" class="menu-link">
                                             <i class="menu-bullet menu-bullet-dot">
                                                 <span></span>
                                             </i>
                                             <span class="menu-text">Edit User</span>
                                         </a>
                                     </li>
                                 </ul>
                             </div>
                         </li>
                         <li class="menu-item menu-item-submenu" aria-haspopup="true"
                             data-menu-toggle="hover">
                             <a href="javascript:;" class="menu-link menu-toggle">
                                 <i class="menu-bullet menu-bullet-line">
                                     <span></span>
                                 </i>
                                 <span class="menu-text">Profile</span>
                                 <i class="menu-arrow"></i>
                             </a>
                             <div class="menu-submenu">
                                 <i class="menu-arrow"></i>
                                 <ul class="menu-subnav">
                                     <li class="menu-item menu-item-submenu" aria-haspopup="true"
                                         data-menu-toggle="hover">
                                         <a href="javascript:;" class="menu-link menu-toggle">
                                             <i class="menu-bullet menu-bullet-dot">
                                                 <span></span>
                                             </i>
                                             <span class="menu-text">Profile 1</span>
                                             <i class="menu-arrow"></i>
                                         </a>
                                         <div class="menu-submenu">
                                             <i class="menu-arrow"></i>
                                             <ul class="menu-subnav">
                                                 <li class="menu-item" aria-haspopup="true">
                                                     <a href="custom/apps/profile/profile-1/overview.html"
                                                         class="menu-link">
                                                         <i class="menu-bullet menu-bullet-line">
                                                             <span></span>
                                                         </i>
                                                         <span class="menu-text">Overview</span>
                                                     </a>
                                                 </li>
                                                 <li class="menu-item" aria-haspopup="true">
                                                     <a href="custom/apps/profile/profile-1/personal-information.html"
                                                         class="menu-link">
                                                         <i class="menu-bullet menu-bullet-line">
                                                             <span></span>
                                                         </i>
                                                         <span class="menu-text">Personal
                                                             Information</span>
                                                     </a>
                                                 </li>
                                                 <li class="menu-item" aria-haspopup="true">
                                                     <a href="custom/apps/profile/profile-1/account-information.html"
                                                         class="menu-link">
                                                         <i class="menu-bullet menu-bullet-line">
                                                             <span></span>
                                                         </i>
                                                         <span class="menu-text">Account
                                                             Information</span>
                                                     </a>
                                                 </li>
                                                 <li class="menu-item" aria-haspopup="true">
                                                     <a href="custom/apps/profile/profile-1/change-password.html"
                                                         class="menu-link">
                                                         <i class="menu-bullet menu-bullet-line">
                                                             <span></span>
                                                         </i>
                                                         <span class="menu-text">Change Password</span>
                                                     </a>
                                                 </li>
                                                 <li class="menu-item" aria-haspopup="true">
                                                     <a href="custom/apps/profile/profile-1/email-settings.html"
                                                         class="menu-link">
                                                         <i class="menu-bullet menu-bullet-line">
                                                             <span></span>
                                                         </i>
                                                         <span class="menu-text">Email Settings</span>
                                                     </a>
                                                 </li>
                                             </ul>
                                         </div>
                                     </li>
                                     <li class="menu-item" aria-haspopup="true">
                                         <a href="custom/apps/profile/profile-2.html"
                                             class="menu-link">
                                             <i class="menu-bullet menu-bullet-dot">
                                                 <span></span>
                                             </i>
                                             <span class="menu-text">Profile 2</span>
                                         </a>
                                     </li>
                                     <li class="menu-item" aria-haspopup="true">
                                         <a href="custom/apps/profile/profile-3.html"
                                             class="menu-link">
                                             <i class="menu-bullet menu-bullet-dot">
                                                 <span></span>
                                             </i>
                                             <span class="menu-text">Profile 3</span>
                                         </a>
                                     </li>
                                     <li class="menu-item" aria-haspopup="true">
                                         <a href="custom/apps/profile/profile-4.html"
                                             class="menu-link">
                                             <i class="menu-bullet menu-bullet-dot">
                                                 <span></span>
                                             </i>
                                             <span class="menu-text">Profile 4</span>
                                         </a>
                                     </li>
                                 </ul>
                             </div>
                         </li>

                         <li class="menu-item" aria-haspopup="true">
                             <a href="custom/apps/inbox.html" class="menu-link">
                                 <i class="menu-bullet menu-bullet-line">
                                     <span></span>
                                 </i>
                                 <span class="menu-text">Inbox</span>
                                 <span class="menu-label">
                                     <span class="label label-danger label-inline">new</span>
                                 </span>
                             </a>
                         </li>
                     </ul>
                 </div>
             </li>
         </ul>
         <!--end::Menu Nav-->
     </div>
     <!--end::Menu Container-->
 </div>