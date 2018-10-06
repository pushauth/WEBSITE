<footer id="footer" class="site-footer" style="">
    <div class="copyright">Copyright &copy; {{date('Y')}} - PushAuth Service | <a href="{{route('page.privacy')}}">Privacy Policy</a></div>
</footer>


@include('dashboard.layout.sidebar')


{{--{!! Html::script('assets/js/jquery.js') !!}
{!! Html::script('assets/js/bootstrap.js') !!}
{!! Html::script('assets/js/metisMenu.js') !!}
{!! Html::script('assets/js/imagesloaded.js') !!}
{!! Html::script('assets/js/masonry.js') !!}
{!! Html::script('assets/js/pace.js') !!}
{!! Html::script('assets/js/bootstrap3-wysihtml5.js') !!}
{!! Html::script('assets/js/icheck.js') !!}
{!! Html::script('assets/js/tether.js') !!}
{!! Html::script('assets/js/tether-shepherd.js') !!}
{!! Html::script('assets/js/main.js') !!}
{!! Html::script('assets/js/notify.js') !!}
{!! Html::script('assets/js/notifyjs-theme.js') !!}--}}

{!! Html::script(elixir('assets/gulp/dashboard-scripts.js')) !!}


<script>
    $(document).ready(function() {
        'use strict';

        var tourStarted = false,
                tour = new Shepherd.Tour({
                    defaults: {
                        classes: 'shepherd-theme-arrows',
                        showCancelLink: true
                    }
                });

        tour.addStep('welcome', {
            text: ['Welcome! This is a guided tour example which you can use PushAuth service.'],
            attachTo: '#tour-trigger bottom',
            buttons: [
                {
                    text: 'Exit',
                    classes: 'shepherd-button-secondary',
                    action: tour.cancel
                }, {
                    text: 'Next',
                    action: tour.next,
                    classes: 'shepherd-button-primary'
                }
            ]
        });

        /*    tour.addStep('dashboards', {
         title: 'Dashboards',
         text: 'Dashboard examples designed for specific use cases to show you the power of the template. We will add more dashboard designs in the future as well!',
         attachTo: '.nav-dashboards right',
         buttons: [
         {
         text: 'Back',
         classes: 'shepherd-button-secondary',
         action: tour.back
         }, {
         text: 'Next',
         action: tour.next
         }
         ]
         });*/

        /*    tour.addStep('Widgets', {
         title: 'Widgets',
         text: 'Check out the various widgets you can use in your projects.',
         attachTo: '.nav-widgets right',
         buttons: [
         {
         text: 'Back',
         classes: 'shepherd-button-secondary',
         action: tour.back
         }, {
         text: 'Next',
         action: tour.next
         }
         ]
         });*/

        tour.addStep('app-pages', {
            title: 'App Pages',
            text: 'First create your App, for use Notification Push Service.',
            attachTo: '.nav-app-pages right',
            buttons: [
                {
                    text: 'Back',
                    classes: 'shepherd-button-secondary',
                    action: tour.back
                }, {
                    text: 'Next',
                    action: tour.next
                }
            ]
        });

        tour.addStep('support-pages', {
            title: 'Support Pages',
            text: 'Read documentation for implement PushAuth to your site or service.',
            attachTo: '.nav-support-pages right',
            buttons: [
                {
                    text: 'Back',
                    classes: 'shepherd-button-secondary',
                    action: tour.back
                }, {
                    text: 'Done',
                    action: tour.next
                }
            ]
        });

        function handleShepherdEvent() {
            tourStarted = false;
        }

        function startTour() {
            tourStarted ? tour.cancel() : tour.start();
            tourStarted = !tourStarted;
        }

        tour.on('complete', handleShepherdEvent);
        tour.on('cancel', handleShepherdEvent);
        $('#tour-trigger').on('click', startTour);

        $('.main-nav-wrapper').on('webkitTransitionEnd transitionend msTransitionEnd oTransitionEnd', function() {
            if(tour.currentStep && tour.currentStep.tether) {
                tour.currentStep.tether.position();
            }
        });

        if($(document.body).data('trigger') == 'tutorial') {
            startTour();
        }

        @if (Session::has('showTour'))
        {{Session::forget('showTour')}}
                startTour();
        @endif

    });

</script>
{!! Html::script('assets/js/forms-wysihtml5.js') !!}
{!! Html::script('assets/js/forms-icheck.js') !!}
{!! Html::script('assets/js/jquery-data-tables.js') !!}
{!! Html::script('assets/js/jquery-data-tables-bs3.js') !!}







<script>



        var CSRF_TOKEN='{!! csrf_token() !!}';
        var SYS_URL='{!! URL::to('/'); !!}';


        $.ajaxSetup({
            // Disable caching of AJAX responses
            cache: false,
            headers: { 'X-CSRF-TOKEN' : CSRF_TOKEN }
        });



</script>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-105769439-1', 'auto');
    ga('send', 'pageview');

</script>
</body>
</html>