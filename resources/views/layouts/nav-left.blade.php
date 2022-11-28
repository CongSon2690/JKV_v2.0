<aside class="main-sidebar sidebar-light-info shadow">
    <div class="d-flex justify-content-center align-items-center py-3">
        <a href="{{ route('home') }}">
            <img src="{{ asset('logo.png') }}" width="50px">
        </a>
    </div>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item has-treeview">
                    <a href="{{ route('home') }}" class="nav-link home">
                        <i class="nav-icon fas fa-home"></i>
                        <p>{{ __('Dashboard') }}</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>
                        {{__('Setting')}}
                        <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                             <a href="{{route('masterData.unit')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{__('Unit')}}</p>
                            </a>
                        </li>  
                        <li class="nav-item">
                             <a href="{{route('masterData.materials')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{__('Materials')}}</p>
                            </a>
                        </li>   
                        <li class="nav-item">
                             <a href="{{route('masterData.product')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{__('Product')}}</p>
                            </a>
                        </li> 
                        <li class="nav-item">
                             <a href="{{route('masterData.machine')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{__('Machine')}}</p>
                            </a>
                        </li> 
                        <li class="nav-item">
                             <a href="{{route('masterData.error')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{__('Error')}}</p>
                            </a>
                        </li> 
                        <li class="nav-item">
                             <a href="{{route('masterData.warehouses')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{__('Warehouse')}}</p>
                            </a>
                        </li>  
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{ route('account') }}" class="nav-link account">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            {{ __('Account') }}
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
