<div class="sidebar-wrapper">
   <div class="logo-wrapper">
      <a href=""><img style="width: 80%" class="img-fluid for-light" src="{{asset('assets/images/adaremit-logo.png')}}" alt="" /><img style="width:80%" class="img-fluid for-dark" src="{{asset('assets/images/adaremit-logo.png')}}" alt="" /></a>
      <div class="back-btn"><i class="fa fa-angle-left"></i></div>
      <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
   </div>
   <div class="logo-icon-wrapper">
      <a href=""><img class="img-fluid" src="{{asset('assets/images/logo/logo-icon.png')}}" alt="" /></a>
   </div>
   <nav class="sidebar-main">
      <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
      <div id="sidebar-menu">
         <ul class="sidebar-links custom-scrollbar">
            <li class="back-btn">
               <a href=""><img class="img-fluid" src="{{asset('assets/images/logo/logo-icon.png')}}" alt="" /></a>
               <div class="mobile-back text-right"><span>Back</span><i class="fa fa-angle-right pl-2" aria-hidden="true"></i></div>
            </li>
            <li class="sidebar-list">
               <a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName()=='dashboard' ? 'active' : '' }}" href="{{route('dashboard')}}"><i data-feather="home"> </i><span>Dashboard</span></a>
            </li>
            <li class="sidebar-list">
               <a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName()=='dashboard' ? 'active' : '' }}" href="{{route('dashboard')}}"><i data-feather="home"> </i><span>Dashboard</span></a>
            </li>
         </ul>
      </div>
      <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
   </nav>
</div>
