<aside class="left-sidebar mt-3">
    <!-- Sidebar scroll-->
    <?php $user = auth()->user();
    $lang = Session::get('locale');
    ?>
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <!-- User Profile-->

                @can('booking_management')
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                            aria-expanded="false">
                            <i class="fas fa-ticket-alt"></i>


                            <span class="hide-menu">{{ __('roles.booking_management') }} </span>
                        </a>
                        @can('all_bookings')
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item">
                                    <a href="{{ route('admin.booking') }}" class="sidebar-link">
                                        <i class="mdi mdi-email"></i>
                                        <span class="hide-menu">{{ __('roles.all_bookings') }}</span>
                                    </a>
                                </li>
                                @can('create_booking')
                                    <li class="sidebar-item">
                                        <a href="{{ route('admin.booking.create') }}" class="sidebar-link">
                                            <i class="mdi mdi-email"></i>
                                            <span class="hide-menu">{{ __('roles.create_booking') }}</span>
                                        </a>
                                    </li>
                                @endcan
                                <li class="sidebar-item">
                                    <a href="{{ route('admin.booking.live_booking') }}" class="sidebar-link">
                                        <i class="mdi mdi-email"></i>
                                        <span class="hide-menu">{{ __('booking.live_booking') }}</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('admin.booking.coming_soon') }}" class="sidebar-link">
                                        <i class="mdi mdi-email"></i>
                                        <span class="hide-menu">{{ __('booking.coming_soon') }}</span>
                                    </a>
                                </li>

                            </ul>
                        @endcan
                    </li>
                @endcan

                @can('hotel_management')
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                            aria-expanded="false">
                            <i class="mdi mdi-hotel"></i>


                            <span class="hide-menu">{{ __('roles.hotel_management') }} </span>
                        </a>
                        @can('all_hotels')
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item">
                                    <a href="{{ route('admin.hotel') }}" class="sidebar-link">
                                        <i class="mdi mdi-email"></i>
                                        <span class="hide-menu">{{ __('roles.all_hotels') }}</span>
                                    </a>
                                </li>
                                @can('create_hotel')
                                    <li class="sidebar-item">
                                        <a href="{{ route('admin.hotel.create') }}" class="sidebar-link">
                                            <i class="mdi mdi-email"></i>
                                            <span class="hide-menu">{{ __('roles.create_hotel') }}</span>
                                        </a>
                                    </li>
                                @endcan
                                {{-- @can('all_meal') --}}
                                    <li class="sidebar-item">
                                        <a href="{{ route('meal.index') }}" class="sidebar-link">
                                            <i class="mdi mdi-email"></i>
                                            <span class="hide-menu">All Meals</span>
                                        </a>
                                    </li>
                                {{-- @endcan --}}
                                {{-- @can('create_meal') --}}
                                    <li class="sidebar-item">
                                        <a href="{{ route('meal.create') }}" class="sidebar-link">
                                            <i class="mdi mdi-email"></i>
                                            <span class="hide-menu">create meal</span>
                                        </a>
                                    </li>
                                {{-- @endcan --}}
                                {{-- @can('cancel_periods') --}}
                                    <li class="sidebar-item">
                                        <a href="{{ route('cancel.index') }}" class="sidebar-link">
                                            <i class="mdi mdi-email"></i>
                                            <span class="hide-menu">ALL Canecelation</span>
                                        </a>
                                    </li>
                                {{-- @endcan --}}
                                {{-- @can('create_cancel_periods') --}}
                                    <li class="sidebar-item">
                                        <a href="{{ route('cancel.create') }}" class="sidebar-link">
                                            <i class="mdi mdi-email"></i>
                                            <span class="hide-menu">Ceate Cancel Period</span>
                                        </a>
                                    </li>
                                {{-- @endcan --}}
                            </ul>
                        @endcan
                    </li>
                @endcan
                @can('service_management')
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                            aria-expanded="false">
                            <i class="fas fa-plus-circle"></i>



                            <span class="hide-menu">{{ __('roles.service_management') }} </span>
                        </a>
                        @can('all_services')
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item">
                                    <a href="{{ route('admin.service') }}" class="sidebar-link">
                                        <i class="mdi mdi-email"></i>
                                        <span class="hide-menu">{{ __('roles.all_services') }}</span>
                                    </a>
                                </li>
                                @can('create_service')
                                    <li class="sidebar-item">
                                        <a href="{{ route('admin.service.create') }}" class="sidebar-link">
                                            <i class="mdi mdi-email"></i>
                                            <span class="hide-menu">{{ __('roles.create_service') }}</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        @endcan
                    </li>
                @endcan
                @can('customer_management')
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                            aria-expanded="false">
                            <i class="fas fa-user"></i>

                            <span class="hide-menu">{{ __('roles.customer_management') }} </span>
                        </a>
                        @can('all_customers')
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item">
                                    <a href="{{ route('admin.customer') }}" class="sidebar-link">
                                        <i class="mdi mdi-email"></i>
                                        <span class="hide-menu">{{ __('roles.all_customers') }}</span>
                                    </a>
                                </li>
                                @can('create_customer')
                                    <li class="sidebar-item">
                                        <a href="{{ route('admin.customer.create') }}" class="sidebar-link">
                                            <i class="mdi mdi-email"></i>
                                            <span class="hide-menu">{{ __('roles.create_customer') }}</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        @endcan
                    </li>
                @endcan
                @can('driver_management')
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                            aria-expanded="false">
                            <i class="fas fa-taxi"></i>
                            <span class="hide-menu">{{ __('roles.driver_management') }} </span>
                        </a>
                        @can('all_drivers')
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item">
                                    <a href="{{ route('admin.driver') }}" class="sidebar-link">
                                        <i class="mdi mdi-email"></i>
                                        <span class="hide-menu">{{ __('roles.all_drivers') }}</span>
                                    </a>
                                </li>
                                @can('create_driver')
                                    <li class="sidebar-item">
                                        <a href="{{ route('admin.driver.create') }}" class="sidebar-link">
                                            <i class="mdi mdi-email"></i>
                                            <span class="hide-menu">{{ __('roles.create_driver') }}</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        @endcan
                    </li>
                @endcan
                @can('driver_management')
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                            aria-expanded="false">
                            <i class="fas fa-taxi"></i>
                            <span class="hide-menu">{{ __('Car management') }} </span>
                        </a>
                        @can('all_drivers')
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item">
                                    <a href="{{ route('car.index') }}" class="sidebar-link">
                                        <i class="mdi mdi-email"></i>
                                        <span class="hide-menu">{{ __('Cars Reservations') }}</span>
                                    </a>
                                </li>
                                @can('create_driver')
                                    <li class="sidebar-item">
                                        <a href="{{ route('car.create') }}" class="sidebar-link">
                                            <i class="mdi mdi-email"></i>
                                            <span class="hide-menu">{{ __('car booking') }}</span>
                                        </a>
                                    </li>
                                    {{-- @can('all_drivers') --}}
                            {{-- <ul aria-expanded="false" class="collapse  first-level"> --}}
                                <li class="sidebar-item">
                                    <a href="{{ route('category.index') }}" class="sidebar-link">
                                        <i class="mdi mdi-email"></i>
                                        <span class="hide-menu">{{ __('Cars Categories') }}</span>
                                    </a>
                                </li>
                                 {{-- @can('create_driver') --}}
                                    <li class="sidebar-item">
                                        <a href="{{ route('category.create') }}" class="sidebar-link">
                                            <i class="mdi mdi-email"></i>
                                            <span class="hide-menu">{{ __('Create Category') }}</span>
                                        </a>
                                    </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('tour.index') }}" class="sidebar-link">
                                        <i class="mdi mdi-email"></i>
                                        <span class="hide-menu">{{ __('Cars tours') }}</span>
                                    </a>
                                </li>
                                 {{-- @can('create_driver') --}}
                                    <li class="sidebar-item">
                                        <a href="{{ route('tour.create') }}" class="sidebar-link">
                                            <i class="mdi mdi-email"></i>
                                            <span class="hide-menu">{{ __('Create tour') }}</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        @endcan



                    </li>
                @endcan
                @can('broker_management')
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                            aria-expanded="false">
                            <i class="fas fa-user-tie"></i>
                            <span class="hide-menu">{{ __('roles.broker_management') }} </span>
                        </a>
                        @can('all_brokers')
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item">
                                    <a href="{{ route('admin.broker') }}" class="sidebar-link">
                                        <i class="mdi mdi-email"></i>
                                        <span class="hide-menu">{{ __('roles.all_brokers') }}</span>
                                    </a>
                                </li>
                                @can('create_broker')
                                    <li class="sidebar-item">
                                        <a href="{{ route('admin.broker.create') }}" class="sidebar-link">
                                            <i class="mdi mdi-email"></i>
                                            <span class="hide-menu">{{ __('roles.create_broker') }}</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        @endcan
                    </li>
                @endcan

                @can('unit_type_management')
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                            aria-expanded="false">
                            <i class="fas fa-th-large"></i>

                            <span class="hide-menu">{{ __('roles.unit_type_management') }} </span>
                        </a>
                        @can('all_unit_types')
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item">
                                    <a href="{{ route('admin.unit_type') }}" class="sidebar-link">
                                        <i class="mdi mdi-email"></i>
                                        <span class="hide-menu">{{ __('roles.all_unit_types') }}</span>
                                    </a>
                                </li>
                                @can('create_unit_type')
                                    <li class="sidebar-item">
                                        <a href="{{ route('admin.unit_type.create') }}" class="sidebar-link">
                                            <i class="mdi mdi-email"></i>
                                            <span class="hide-menu">{{ __('roles.create_unit_type') }}</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        @endcan
                    </li>
                @endcan
                @can('user_management')
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                            aria-expanded="false">
                            <i class="fa fa-users"></i>

                            <span class="hide-menu">{{ __('roles.user_management') }} </span>
                        </a>
                        @can('all_users')
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item">
                                    <a href="{{ route('admin.user_managment') }}" class="sidebar-link">
                                        <i class="mdi mdi-email"></i>
                                        <span class="hide-menu">{{ __('roles.all_users') }}</span>
                                    </a>
                                </li>

                            </ul>
                        @endcan
                    </li>
                @endcan
                @can('admin_roles')
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                            aria-expanded="false">
                            <i class="fa fa-id-badge"></i>


                            <span class="hide-menu">{{ __('roles.roles') }} </span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            @can('show_admin_roles')
                                <li class="sidebar-item">
                                    <a href="{{ route('admin.roles') }}" class="sidebar-link">
                                        <i class="mdi mdi-email"></i>
                                        <span class="hide-menu">{{ __('roles.all_roles') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('create_admin_roles')
                                <li class="sidebar-item">
                                    <a href="{{ route('admin.roles.create') }}" class="sidebar-link">
                                        <i class="mdi mdi-email"></i>
                                        <span class="hide-menu">{{ __('roles.create_role') }}</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('departments')
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                            aria-expanded="false">
                            <i class="fas fa-tags nav-icon"></i>


                            <span class="hide-menu">{{ __('departments.departments') }} </span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            @can('all_departments')
                                <li class="sidebar-item">
                                    <a href="{{ route('all_departments') }}" class="sidebar-link">
                                        <i class="mdi mdi-email"></i>
                                        <span class="hide-menu">{{ __('departments.all_departments') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('create_department')
                                <li class="sidebar-item">
                                    <a href="{{ route('departments.create_department') }}" class="sidebar-link">
                                        <i class="mdi mdi-email"></i>
                                        <span class="hide-menu">{{ __('departments.create_department') }}</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan




                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('logout') }}"
                        aria-expanded="false">
                        <i class="mdi mdi-directions"></i>
                        <span class="hide-menu">{{ __('login.logout') }}</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
