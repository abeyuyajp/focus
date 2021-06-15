<div class="container-fluid pl-0">
            <div class="row">
                <nav id="sidebarMenu" class="col-1 d-md-block bg-navy sidebar collapse">
                    <div class="position-sticky pt-3">
                        <ul class="nav flex-column">
                            <li class="nav-item mb-5 mt-5 text-center" >
                                <a class="text-white link-none" href="{{ url('/') }}">
                                    <i class="far fa-edit fa-2x"></i>
                                    <p><strong>セッション</strong></p>
                                </a>
                            </li>
                            <li class="nav-item mb-5 mt-5 text-center">
                                <a class="text-white link-none" href="{{ url('/calendar') }}">
                                    <i class="far fa-calendar-alt fa-2x "></i>
                                    <p><strong>カレンダー</strong></p>
                                </a>
                            </li>
                            <!--プロフィール画像の表示-->
                            @if (Auth::check() )
                            <li class="nav-item mb-5 mt-5 text-center">
                                <a  class="text-white link-none" href="{{ url('/user/edit') }}">
                                    @if(!empty(Auth::user()->profile_image))
                                        <img src="{{ asset('storage/image/' . Auth::user()->profile_image) }}"  width="45vw" height="45px" style="border-radius: 100%;">
                                    @else
                                        <i class="far fa-user-circle fa-3x"></i>
                                    @endif
                                    <p class="lead text-white text-center">{{ Auth::user()->name }}</p>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </nav>
            </div>
</div>