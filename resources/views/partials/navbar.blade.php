<nav class="navbar navbar-default {{$nav_class}}" style="margin-bottom: 0px; font-size: 12px; font-weight: bold;">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}" style="position: relative;
    background: url(/img/logo3.png) no-repeat;
    width: 150px;
    left: 15px;
    background-size: contain;
            ">
            
                
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                &nbsp;
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Navbar Links -->
                <li>
                    @include('search.search_input')
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Τοπ Λίστες<span class="caret"></span></a>
                    <ul class="dropdown-menu" style="color:white; background-color: black;">
                      <li><a href="{{route('alltime.show')}}" style="color:white;">Κορυφαίές Επιδόσεις</a></li>
                      <li><a href="{{route('toplist.show')}}" style="color:white;">Ανά Σεζόν</a></li>
                    </ul>
                </li>

                <li><a href="{{ route('record.showNRs') }}">Παγκύπρια Ρεκόρ</a></li>
                <li><a href="{{ route('record.showNRsHistory') }}">Πρόοδος Παγκύπριων Ρεκόρ</a></li>
                <li><a href="{{ route('competition.calendar') }}">Ημερολόγιο Αγώνων</a></li>
                <li><a href="#">Επικοινωνία</a></li>

            </ul>
        </div>
    </div>
</nav>