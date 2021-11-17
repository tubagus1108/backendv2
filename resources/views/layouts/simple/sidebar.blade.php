<div class="sidebar-wrapper">
   <div class="logo-wrapper">
      <a href=""><img style="width: 80%" class="img-fluid for-light" src="{{asset('assets/images/adaremit-logo.png')}}" alt="" /><img style="width:80%" class="img-fluid for-dark" src="{{asset('assets/images/adaremit-logo.png')}}" alt="" /></a>
      <div class="back-btn"><i class="fa fa-angle-left"></i></div>
      <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
   </div>
   <div class="logo-icon-wrapper">
      <a href="{{route('dashboard')}}"><img class="img-fluid" src="{{asset('assets/images/logo/logo-icon.png')}}" alt="" /></a>
   </div>
   <nav class="sidebar-main">
      <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
      <div id="sidebar-menu">
         <ul class="sidebar-links custom-scrollbar">
            <li class="back-btn">
               <a href="{{route('dashboard')}}"><img class="img-fluid" src="{{asset('assets/images/logo/logo-icon.png')}}" alt="" /></a>
               <div class="mobile-back text-right"><span>Back</span><i class="fa fa-angle-right pl-2" aria-hidden="true"></i></div>
            </li>
            <li class="sidebar-list">
               <a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName()=='dashboard' ? 'active' : '' }}" href="{{route('dashboard')}}"><i data-feather="home"> </i><span>Dashboard</span></a>
            </li>
            <li class="sidebar-list">
               <a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName()=='index-users' ? 'active' : '' }}" href="{{route('index-users')}}"><i data-feather="users"> </i><span>Users</span></a>
            </li>
            <li class="sidebar-list">
               <a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName()=='transactions-all' ? 'active' : '' }}" href="{{route('transactions-all')}}"><i data-feather="shopping-cart"> </i><span>Transactions</span></a>
            </li>
            <li class="sidebar-list">
               <a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName()=='vendor-order' ? 'active' : '' }}" href=""><i data-feather="briefcase"> </i><span>Vendor Orders</span></a>
            </li>
            <li class="sidebar-list">
               <a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/order-manual' ? 'active' : '' }}" href="#">
                  <i data-feather="shopping-cart"></i><span>Order Manual</span>
                  <div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/order-manual' ? 'down' : 'right' }}"></i></div>
               </a>
               <ul class="sidebar-submenu" style="display: {{request()->route()->getPrefix() == '/order-manual' ? 'block' : 'none;' }};">
                     <li><a href="" class="{{ Route::currentRouteName()=='product' ? 'active' : '' }}">Tambah Pengirim</a></li>
                     <li><a href="" class="{{ Route::currentRouteName()=='product-page' ? 'active' : '' }}">Tambah Penerima</a></li>
                     <li><a href="" class="{{ Route::currentRouteName()=='list-products' ? 'active' : '' }}">Transaksi</a></li>
                     <li><a href="" class="{{ Route::currentRouteName()=='payment-details' ? 'active' : '' }}">Print Bon</a></li>
                     <li><a href="" class="{{ Route::currentRouteName()=='order-history' ? 'active' : '' }}">Print Invoice</a></li>
                     <li><a href="" class="{{ Route::currentRouteName()=='invoice-template' ? 'active' : '' }}">Laporan Manual</a></li>
               </ul>
            </li>
            <li class="sidebar-list">
               <a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/reports' ? 'active' : '' }}" href="#">
                  <i data-feather="book-open"></i><span>Reports</span>
                  <div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/reports' ? 'down' : 'right' }}"></i></div>
               </a>
               <ul class="sidebar-submenu" style="display: {{request()->route()->getPrefix() == '/reports' ? 'block' : 'none;' }};">
                     <li><a href="" class="{{ Route::currentRouteName()=='product' ? 'active' : '' }}">Daily Report</a></li>
                     <li><a href="" class="{{ Route::currentRouteName()=='product-page' ? 'active' : '' }}">Report BI</a></li>
                     <li><a href="" class="{{ Route::currentRouteName()=='list-products' ? 'active' : '' }}">Report Sales</a></li>
                     <li><a href="" class="{{ Route::currentRouteName()=='payment-details' ? 'active' : '' }}">Report Sipesat</a></li>
                     <li><a href="" class="{{ Route::currentRouteName()=='order-history' ? 'active' : '' }}">Balance Vendor</a></li>
                     <li><a href="" class="{{ Route::currentRouteName()=='invoice-template' ? 'active' : '' }}">Data User</a></li>
                     <li><a href="" class="{{ Route::currentRouteName()=='cart' ? 'active' : '' }}">Data Order</a></li>
                     <li><a href="" class="{{ Route::currentRouteName()=='list-wish' ? 'active' : '' }}">Data Transactions</a></li>
                     <li><a href="" class="{{ Route::currentRouteName()=='checkout' ? 'active' : '' }}">Data Laba Rugi</a></li>
                     <li><a href=""" class="{{ Route::currentRouteName()=='pricing' ? 'active' : '' }}">Download Report PPATK</a></li>
               </ul>
            </li>
            <li class="sidebar-list">
               <a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/reports' ? 'active' : '' }}" href="#">
                  <i data-feather="settings"></i><span>Settings</span>
                  <div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/reports' ? 'down' : 'right' }}"></i></div>
               </a>
               <ul class="sidebar-submenu" style="display: {{request()->route()->getPrefix() == '/reports' ? 'block' : 'none;' }};">
                     <li><a href="" class="{{ Route::currentRouteName()=='product' ? 'active' : '' }}">KYC</a></li>
                     <li><a href="" class="{{ Route::currentRouteName()=='product-page' ? 'active' : '' }}">Voucher</a></li>
                     <li><a href="" class="{{ Route::currentRouteName()=='list-products' ? 'active' : '' }}">Compare Kurs</a></li>
                     <li><a href="" class="{{ Route::currentRouteName()=='payment-details' ? 'active' : '' }}">Kurs</a></li>
                     <li><a href="" class="{{ Route::currentRouteName()=='order-history' ? 'active' : '' }}">Vendor-List</a></li>
                     <li><a href="" class="{{ Route::currentRouteName()=='invoice-template' ? 'active' : '' }}">Change Password</a></li>
                     <li><a href="" class="{{ Route::currentRouteName()=='cart' ? 'active' : '' }}">Upload Data BI</a></li>
                     <li><a href="" class="{{ Route::currentRouteName()=='list-wish' ? 'active' : '' }}">Bank</a></li>
                     <li><a href="" class="{{ Route::currentRouteName()=='checkout' ? 'active' : '' }}">Countries</a></li>
                     <li><a href=""" class="{{ Route::currentRouteName()=='pricing' ? 'active' : '' }}">Terms and Condetions</a></li>
                     <li><a href=""" class="{{ Route::currentRouteName()=='pricing' ? 'active' : '' }}">Privacy Policy</a></li>
                     <li><a href=""" class="{{ Route::currentRouteName()=='pricing' ? 'active' : '' }}">Promo</a></li>
               </ul>
            </li>
         </ul>
      </div>
      <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
   </nav>
</div>
