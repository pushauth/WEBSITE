<div class="module-wrapper">
    <a name="exceptions"></a>
    <section class="module member-module module-no-heading module-no-footer">
        <div class="module-inner">
            <div class="module-heading">
                <h3 class="module-title">Exceptions</h3>


            </div>
            <div class="module-content">
                <div class="module-content-inner no-padding-bottom">
                    <div class="topic-holder">

<p> This section describes the basic error codes for response. If the code is 4xx or 5xx, then most likely there will be json values: <span class="label label-success">status_code</span> and <span class="label label-success">message</span>.</p>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Description</th>

                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th>200 OK</th>
                                    <td>Successfully processed request</td>

                                </tr>
                                <tr>
                                    <th>403 Access Denied</th>
                                    <td>Access is denied, the user or device may be locked</td>

                                </tr>
                                <tr>
                                    <th>404 Not Found</th>
                                    <td>Not found</td>

                                </tr>
                                <tr>
                                    <th>405 Method Not Allowed</th>
                                    <td>The request was not sent by that method (POST/GET/PATCH/DELETE)</td>

                                </tr>
                                <tr>
                                    <th>422 Unprocessable Entity</th>
                                    <td>Error in request parameter</td>

                                </tr>
                                <tr>
                                    <th>500 Internal Server Error</th>
                                    <td>Error in server side</td>

                                </tr>


                                </tbody>
                            </table>
                        </div>








                    </div>



                </div>
            </div>
        </div>
    </section>
</div>