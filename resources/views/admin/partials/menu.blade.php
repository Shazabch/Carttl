<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
    <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1"
        data-menu-dropdown-timeout="500">
        <ul class="menu-nav">

            {{-- Define the user and the privileged status once, respecting the 'admin' guard. --}}
            @php
                $user = auth()->guard('admin')->user();
                // Checks if the authenticated user has either 'super-admin' or 'admin' role.
                $isPrivilegedUser = $user && ($user->hasRole('super-admin') || $user->hasRole('admin'));
            @endphp

            <li class="menu-item {{ request()->routeIs('admin.dashboard') ? 'menu-item-active' : '' }}"
                aria-haspopup="true">
                {{-- Show if privileged OR has the base permission --}}
                @if ($isPrivilegedUser || $user->can('dashboard-view'))
                    <a href="{{ route('admin.dashboard') }}" class="menu-link">
                        <span class="svg-icon menu-icon">
                            <i class="fas fa-tachometer-alt"></i>
                        </span>
                        <span class="menu-text">Dashboard</span>
                    </a>
                @endif
            </li>

            {{-- ENQUIRIES SECTION --}}
            {{-- We can't use $user->can() with a logical OR for the section heading, so we check all relevant permissions manually. --}}
            @if ($isPrivilegedUser || $user->can('inspection-list'))
                <li class="menu-section">
                    <h4 class="menu-text">Enquiries</h4>
                    <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                </li>

                <li class="menu-item menu-item-submenu {{ request()->routeIs('admin.submissions') || request()->routeIs('admin.inspection.enquiries') || request()->routeIs('admin.purchase.list') || request()->routeIs('admin.sell.list') ? 'menu-item-open menu-item-active' : '' }}"
                    aria-haspopup="true" data-menu-toggle="hover">
                    {{-- Dropdown visibility check: must be privileged OR have a key list permission --}}
                    @if ($isPrivilegedUser || $user->can('inspection-list'))
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <span class="svg-icon menu-icon">
                                <i class="fas fa-envelope-open-text"></i>
                            </span>
                            <span class="menu-text">Enquiry Management</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                 @if ($isPrivilegedUser)
                                {{-- Contact Enquiries (Covered by parent check, using 'client-list' as proxy) --}}
                                <li class="menu-item {{ request()->routeIs('admin.submissions') ? 'menu-item-active' : '' }}"
                                    aria-haspopup="true">
                                    <a href="{{ route('admin.submissions') }}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                        <span class="menu-text">Contact Enquiries</span>
                                    </a>
                                </li>
                                @endif
                                {{-- Inspection Enquiries: Specific check 'inspection-list' --}}
                                @if ($isPrivilegedUser || $user->can('inspection-list'))
                                <li class="menu-item {{ request()->routeIs('admin.inspection.enquiries') ? 'menu-item-active' : '' }}"
                                    aria-haspopup="true">
                                    <a href="{{ route('admin.inspection.enquiries') }}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                        <span class="menu-text">Inspection Enquiries</span>
                                    </a>
                                </li>
                                @endif
                                  @if ($isPrivilegedUser)
                                {{-- Purchase/Sell Enquiries (Covered by parent check, using 'client-list' as proxy) --}}
                                <li class="menu-item {{ request()->routeIs('admin.purchase.list') ? 'menu-item-active' : '' }}"
                                    aria-haspopup="true">
                                    <a href="{{ route('admin.purchase.list') }}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                        <span class="menu-text">Purchase Enquiries</span>
                                    </a>
                                </li>
                                <li class="menu-item {{ request()->routeIs('admin.sell.list') ? 'menu-item-active' : '' }}"
                                    aria-haspopup="true">
                                    <a href="{{ route('admin.sell.list') }}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                        <span class="menu-text">Sell Enquiries</span>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    @endif
                </li>
            @endif


            {{-- VEHICLES SECTION --}}
            {{-- Section visibility check: show if privileged OR has any permission for this section --}}
            @if ($isPrivilegedUser || $user->can('inspection-create') || $user->can('vehicle-list'))
                <li class="menu-section">
                    <h4 class="menu-text">Vehicles</h4>
                    <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                </li>

                <li class="menu-item menu-item-submenu {{ request()->routeIs('admin.inspection.generate') ? 'menu-item-open menu-item-active' : '' }}"
                    aria-haspopup="true" data-menu-toggle="hover">
                    @if ($isPrivilegedUser || $user->can('inspection-create'))
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <span class="svg-icon menu-icon">
                                <i class="fas fa-car"></i>
                            </span>
                            <span class="menu-text">Vehicle Inspection</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item {{ request()->routeIs('admin.inspection.generate') ? 'menu-item-active' : '' }}"
                                    aria-haspopup="true">
                                    <a href="{{ route('admin.inspection.generate') }}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                        <span class="menu-text">Inspect</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    @endif
                </li>

                <li class="menu-item menu-item-submenu {{ request()->routeIs('admin.manage.bids') ? 'menu-item-open menu-item-active' : '' }}"
                    aria-haspopup="true" data-menu-toggle="hover">
                    @if ($isPrivilegedUser || $user->can('vehicle-list'))
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <span class="svg-icon menu-icon">
                                <i class="fas fa-hammer"></i>
                            </span>
                            <span class="menu-text">Vehicle Biddings</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item {{ request()->routeIs('admin.manage.bids') ? 'menu-item-active' : '' }}"
                                    aria-haspopup="true">
                                    <a href="{{ route('admin.manage.bids') }}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                        <span class="menu-text">All Bids</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    @endif
                </li>

                <li class="menu-item menu-item-submenu {{ request()->is('admin/vehicles/add') || request()->is('admin/vehicles/all') || request()->is('admin/vehicles/listed') || request()->is('admin/vehicles/pending') || request()->is('admin/vehicles/sold') ? 'menu-item-open menu-item-active' : '' }}"
                    aria-haspopup="true" data-menu-toggle="hover">
                    @if ($isPrivilegedUser || $user->can('vehicle-list'))
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <span class="svg-icon menu-icon">
                                <i class="fas fa-car"></i>
                            </span>
                            <span class="menu-text">Vehicle Management</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                {{-- All Makes (Assumed covered by vehicle-list or general management access) --}}
                                <li class="menu-item {{ request()->is('admin/makes') ? 'menu-item-active' : '' }}"
                                    aria-haspopup="true">
                                    <a href="{{ route('admin.makes.all') }}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                        <span class="menu-text">All Makes</span>
                                    </a>
                                </li>

                                {{-- Add Vehicle: Specific check 'vehicle-create' --}}
                                @if ($isPrivilegedUser || $user->can('vehicle-create'))
                                    <li class="menu-item {{ request()->is('admin/vehicles/add') ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{ route('admin.vehicles','add') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                            <span class="menu-text">Add Vehicle</span>
                                        </a>
                                    </li>
                                @endif
                                
                                {{-- All list links (Covered by parent check: 'vehicle-list') --}}
                                <li class="menu-item {{ request()->is('admin/vehicles/all') ? 'menu-item-active' : '' }}"
                                    aria-haspopup="true">
                                    <a href="{{ route('admin.vehicles','all') }}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                        <span class="menu-text">All Vehicles</span>
                                    </a>
                                </li>
                                <li class="menu-item {{ request()->is('admin/vehicles/listed') ? 'menu-item-active' : '' }}"
                                    aria-haspopup="true">
                                    <a href="{{ route('admin.vehicles','listed') }}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                        <span class="menu-text">Listed Vehicles</span>
                                    </a>
                                </li>
                                <li class="menu-item {{ request()->is('admin/vehicles/pending') ? 'menu-item-active' : '' }}"
                                    aria-haspopup="true">
                                    <a href="{{ route('admin.vehicles','pending') }}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                        <span class="menu-text">Pending Vehicles</span>
                                    </a>
                                </li>
                                <li class="menu-item {{ request()->is('admin/vehicles/sold') ? 'menu-item-active' : '' }}"
                                    aria-haspopup="true">
                                    <a href="{{ route('admin.vehicles','sold') }}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                        <span class="menu-text">Sold Vehicles</span>
                                    </a>
                                </li>
                                <li class="menu-item {{ request()->routeIs('admin.vehicles.enquiries','sale') ? 'menu-item-active' : '' }}"
                                    aria-haspopup="true">
                                    <a href="{{ route('admin.vehicles.enquiries','sale') }}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                        <span class="menu-text">All Vehicle Enquiries</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    @endif
                </li>
            @endif


            {{-- ADMINISTRATOR SECTION --}}
            {{-- Section visibility check: show if privileged OR has any core admin permission --}}
            @if ($isPrivilegedUser || $user->can('role-list') || $user->can('user-list'))
                <li class="menu-section">
                    <h4 class="menu-text">Administrator</h4>
                    <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                </li>

                <li class="menu-item menu-item-submenu {{ request()->routeIs('admin.roles') || request()->routeIs('admin.user') || request()->routeIs('admin.blogs') || request()->routeIs('admin.testimonials') ? 'menu-item-open menu-item-active' : '' }}"
                    aria-haspopup="true" data-menu-toggle="hover">
                    @if ($isPrivilegedUser || $user->can('role-list') || $user->can('user-list'))
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <span class="svg-icon menu-icon">
                                <i class="fas fa-cogs"></i>
                            </span>
                            <span class="menu-text">System Settings</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                {{-- Roles: Specific check 'role-list' --}}
                                @if ($isPrivilegedUser || $user->can('role-list'))
                                <li class="menu-item {{ request()->routeIs('admin.roles') ? 'menu-item-active' : '' }}"
                                    aria-haspopup="true">
                                    <a href="{{ route('admin.roles') }}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                        <span class="menu-text">Roles</span>
                                    </a>
                                </li>
                                @endif
                                {{-- Users: Specific check 'user-list' --}}
                                @if ($isPrivilegedUser || $user->can('user-list'))
                                <li class="menu-item {{ request()->routeIs('admin.user') ? 'menu-item-active' : '' }}"
                                    aria-haspopup="true">
                                    <a href="{{ route('admin.user') }}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                        <span class="menu-text">Users</span>
                                    </a>
                                </li>
                                @endif
                                {{-- Blogs/Testimonials (Assumed to require 'user-list' or similar general admin access) --}}
                                @if ($isPrivilegedUser || $user->can('user-list')) 
                                    <li class="menu-item {{ request()->routeIs('admin.blogs') ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{ route('admin.blogs') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                            <span class="menu-text">Blogs</span>
                                        </a>
                                    </li>
                                    <li class="menu-item {{ request()->routeIs('admin.testimonials') ? 'menu-item-active' : '' }}"
                                        aria-haspopup="true">
                                        <a href="{{ route('admin.testimonials') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                            <span class="menu-text">Testimonials</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    @endif
                </li>
            @endif

        </ul>
    </div>
</div>