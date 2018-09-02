 <footer class="page-footer red lighten-3">
    <div class="container">
        <div class="row">
            <div class="col l6 s12">
                <h5 class="white-text">Company Bio</h5>
                <p class="white-text">
                    @if(!empty($bioFooter))
                    {!! $bioFooter !!}
                    @endif
                </p>
            </div>
            <div class="col l3 s12">
                <h5 class="white-text">Sites</h5>
                <ul>
                    <li><a class="white-text" href="{{ route('faqs') }}">FAQs</a></li>
                    <li><a class="white-text" href="{{ route('contacts') }}">Contact Us</a></li>
                    <li><a class="white-text" href="{{ route('about') }}">About</a></li>
                </ul>
            </div>
            <div class="col l3 s12">
                <h5 class="white-text">Connect</h5>
                <ul>
                    @if(!empty($socialMedia))
                    @foreach($socialMedia as $sm) 
                    <li><a class="white-text" href="#!">
                            {{-- @if(strtolower($sm->name) == 'instagram')
                            <i class="fa fa-icon fa-instagram"> </i>
                            @elseif(strtolower($sm->name) == 'whatsapp')
                            <i class="fa fa-icon fa-phone"> </i> 
                            @else
                            {{ ucfirst(strtolower($sm->name)) }}: 
                            @endif --}}
                            {{ $sm->url }}
                        </a>
                    </li>
                    @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container white-text">
            <b>
                Copyright <a class="white-text" href="http://materializecss.com">© Clouwny</a> 2017
            </b>
        </div>
    </div>
</footer>