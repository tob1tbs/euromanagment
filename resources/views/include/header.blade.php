<div class="nk-header nk-header-fluid is-theme">
    <div class="container-xl wide-xl">
        <div class="nk-header-wrap">
            <div class="nk-menu-trigger mr-sm-2 d-lg-none">
                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="headerNav"><em class="icon ni ni-menu"></em></a>
            </div>
            <div class="nk-header-brand">
                <a href="{{ route('actionMainIndex') }}" class="logo-link">
                    <img class="logo-light logo-img" src="{{ url('assets/images/logo.png') }}" srcset="{{ url('assets/images/logo2x.png') }} 2x" alt="logo">
                    <img class="logo-dark logo-img" src="{{ url('assets/images/logo-dark.png') }}" srcset="{{ url('assets/images/logo-dark2x.png') }} 2x" alt="logo-dark">
                </a>
            </div>
            <div class="nk-header-menu" data-content="headerNav">
                <div class="nk-header-mobile">
                    <div class="nk-header-brand">
                        <a href="{{ route('actionMainIndex') }}" class="logo-link">
                            <img class="logo-light logo-img" src="{{ url('assets/images/logo.png') }}" srcset="{{ url('assets/images/logo2x.png') }} 2x" alt="logo">
                            <img class="logo-dark logo-img" src="{{ url('assets/images/logo-dark.png') }}" srcset="{{ url('assets/images/logo-dark2x.png') }} 2x" alt="logo-dark">
                        </a>
                    </div>
                    <div class="nk-menu-trigger mr-n2">
                        <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="headerNav"><em class="icon ni ni-arrow-left"></em></a>
                    </div>
                </div>
                <ul class="nk-menu nk-menu-main ui-s2">
                    <li class="nk-menu-item">
                        <a href="{{ route('actionMainIndex') }}" class="nk-menu-link">
                            <span class="nk-menu-text">მთავარი გვერდი</span>
                        </a>
                    </li>
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-text">თანამშრომლები</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{ route('actionUsersIndex') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">ჩამონათვალი</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('actionUsersRole') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">წვდომის ჯგუფები</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('actionUsersPositions') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">სამუშაო პოზიციები</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('actionUsersCalendar') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">სამუშაო კალენდარი</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('actionUsersSalary') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">თანამშრომელთა ხელფასები</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-text">კომპანია</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{ route('actionCompanyBranch') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">ფილიალები</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="nk-header-tools">
                <ul class="nk-quick-nav">
                    <li class="dropdown notification-dropdown">
                        <a href="#" class="dropdown-toggle nk-quick-nav-icon" data-toggle="dropdown">
                            <div class="icon-status icon-status-info">
                                <em class="icon ni ni-bell"></em>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right dropdown-menu-s1">
                            <div class="dropdown-head">
                                <span class="sub-title nk-dropdown-title">Notifications</span>
                                <a href="#">Mark All as Read</a>
                            </div>
                            <div class="dropdown-body">
                                <div class="nk-notification">
                                    <div class="nk-notification-item dropdown-inner">
                                        <div class="nk-notification-icon">
                                            <em class="icon icon-circle bg-warning-dim ni ni-curve-down-right"></em>
                                        </div>
                                        <div class="nk-notification-content">
                                            <div class="nk-notification-text">You have requested to <span>Widthdrawl</span></div>
                                            <div class="nk-notification-time">2 hrs ago</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-foot center">
                                <a href="#">View All</a>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown user-dropdown order-sm-first">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <div class="user-toggle">
                                <div class="user-avatar sm">
                                    <em class="icon ni ni-user-alt"></em>
                                </div>
                                <div class="user-info d-none d-xl-block">
                                    <div class="user-name dropdown-indicator">მოგესალმები: </div>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right dropdown-menu-s1 is-light">
                            <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                <div class="user-card">
                                    <div class="user-info">
                                        <span class="lead-text"></span>
                                        <span class="sub-text"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-inner">
                                <ul class="link-list font-helvetica-regular">
                                    <li><a href=""><em class="icon ni ni-user-alt"></em><span>ჩემი პროფილი</span></a></li>
                                    <li><a href=""><em class="icon ni ni-signout"></em><span>გასვლა</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>