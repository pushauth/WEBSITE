@include('dashboard.layout.header')

{!!  Html::style('assets/css/help.css') !!}



@include('dashboard.layout.topalert')

@include('dashboard.layout.topbar')

@include('dashboard.layout.leftbar')






<div id="content-wrapper" class="content-wrapper view">
    <div class="container-fluid">
        <h2 class="view-title">Help</h2>
        <div class="row">
            <div class="module-wrapper col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <section class="module module-headings">
                    <div class="module-inner">
                        <div class="module-content">
                            <div class="module-content-inner">
                                <div class="help-section">
                                    <div class="help-search">
                                        <h3 class="text-center title">What can we help you with?</h3>
                                        <form class="search-box form-inline text-center margin-bottom-lg">
                                            <label class="sr-only" for="help-search-form">Search</label>
                                            <div class="form-group">
                                                <input id="help-search-form" name="search-form" type="text" class="form-control help-search-form" placeholder="Search questions...">
                                                <button type="submit" class="btn btn-primary btn-single-icon"><i class="fa fa-search"></i></button>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="help-category-wrapper margin-bottom-lg">
                                        <div class="row text-center">
                                            <div class="cat-item col-md-6 col-sm-6 col-xs-12  margin-bottom-lg">
                                                <h4 class="cat-title">Getting Started</h4>
                                                <ul class="list list-unstyled margin-bottom-sm">
                                                    <li><a href="#">How to lorem ipsum?</a></li>
                                                    <li><a href="#">How to curabitur malesuada hendrerit?</a></li>
                                                    <li><a href="#">Can I gravida quis diam ac euismod?</a></li>
                                                    <li><a href="#">What is consectetur aliquam tortor?</a></li>
                                                </ul>
                                                <a class="btn btn-default">View all 16 articles</a>
                                            </div>

                                            <div class="cat-item col-md-6 col-sm-6 col-xs-12  margin-bottom-lg">
                                                <h4 class="cat-title">Pricing &amp; Billing</h4>
                                                <ul class="list list-unstyled margin-bottom-sm">
                                                    <li><a href="#">How to lorem ipsum?</a></li>
                                                    <li><a href="#">How to curabitur malesuada hendrerit?</a></li>
                                                    <li><a href="#">Can I gravida quis diam ac euismod?</a></li>
                                                    <li><a href="#">What is consectetur aliquam tortor?</a></li>
                                                </ul>
                                                <a class="btn btn-default">View all 12 articles</a>
                                            </div>

                                        </div>

                                        <div class="row text-center">
                                            <div class="cat-item col-md-6 col-sm-6 col-xs-12 margin-bottom-lg">
                                                <h4 class="cat-title">Account Management</h4>
                                                <ul class="list list-unstyled margin-bottom-sm">
                                                    <li><a href="#">How to lorem ipsum?</a></li>
                                                    <li><a href="#">How to curabitur malesuada hendrerit?</a></li>
                                                    <li><a href="#">Can I gravida quis diam ac euismod?</a></li>
                                                    <li><a href="#">What is consectetur aliquam tortor?</a></li>
                                                </ul>
                                                <a class="btn btn-default">View all 15 articles</a>
                                            </div>

                                            <div class="cat-item col-md-6 col-sm-6 col-xs-12  margin-bottom-lg">
                                                <h4 class="cat-title">File Management</h4>
                                                <ul class="list list-unstyled margin-bottom-sm">
                                                    <li><a href="#">How can I nunc iaculis lorem eget?</a></li>
                                                    <li><a href="#">What is to malesuada hendrerit?</a></li>
                                                    <li><a href="#">Can I gravida quis diam ac euismod?</a></li>
                                                    <li><a href="#">How to consectetur aliquam tortor?</a></li>
                                                </ul>
                                                <a class="btn btn-default">View all 7 articles</a>
                                            </div>

                                        </div>

                                        <div class="row text-center">
                                            <div class="cat-item col-md-6 col-sm-6 col-xs-12 margin-bottom-lg">
                                                <h4 class="cat-title">Project Management</h4>
                                                <ul class="list list-unstyled margin-bottom-sm">
                                                    <li><a href="#">How to lorem ipsum malesuada hendrerit?</a></li>
                                                    <li><a href="#">How to curabitur malesuada hendrerit?</a></li>
                                                    <li><a href="#">Can I gravida quis diam ac euismod?</a></li>
                                                    <li><a href="#">What is consectetur aliquam tortor?</a></li>
                                                </ul>
                                                <a class="btn btn-default">View all 21 articles</a>
                                            </div>

                                            <div class="cat-item col-md-6 col-sm-6 col-xs-12">
                                                <h4 class="cat-title">Upgrading</h4>
                                                <ul class="list list-unstyled margin-bottom-sm">
                                                    <li><a href="#">Can I consectetur aliquam gravida?</a></li>
                                                    <li><a href="#">Should I curabitur malesuada hendrerit?</a></li>
                                                    <li><a href="#">How can I gravida quis diam ac euismod?</a></li>
                                                    <li><a href="#">What is consectetur aliquam tortor?</a></li>
                                                </ul>
                                                <a class="btn btn-default">View all 6 articles</a>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="help-lead text-center margin-bottom-lg">
                                        <h4 class="subtitle">Still need help?</h4>
                                        <a class="btn btn-success" href="#"><i class="fa fa-paper-plane"></i> Contact Us</a>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                </section>

            </div>

        </div>

    </div>

</div>











@include('dashboard.layout.sidebar')

@include('dashboard.layout.footer')
