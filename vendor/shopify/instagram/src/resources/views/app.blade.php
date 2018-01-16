@extends('instagram::layout')
@section ('body')
    <?php
    $setting  = unserialize($setting);
    $setting_saved = $resolution = $feed_limit = $space = $sortby = $open_ig = $user_instagram_id = false;
    if (is_array($setting)) {
        $setting_saved = true;
        $resolution = $setting[0];
        $feed_limit = $setting[1];
        $space = $setting[2];
        $sortby = $setting[3];
        $open_ig = $setting[4];
        $user_instagram_id = $setting[5];
    }
    ?>
    <main>
        <section class="full-width" style="padding: 18px 18px 0 18px;">
            <div class="card columns one-half">
                <form action="#" method="POST" style="display:inline;">
                    {{ csrf_field() }}
                    <div class="row">
                        <label><b>Your Instagram Access Token:</b></label>
                        <input type="text" name="access_token" placeholder="access token" value="{{ $access_token }}" style="margin-bottom:0;">
                        <em>Generate your Instagram account <a href="http://shopeasify.com/instagram-app/" target="_blank"><b>access token here</b></a></em>
                    </div>

                    <div class="row">
                        <div class="column">
                            <label><b>Pictures Resolution:</b></label>
                            <div class="standard_resolution">
                                <img src="{{ asset('/vendor/shopify/instagram/images/size_resolution_1.png') }}" alt="">
                                <label><input @if ($setting_saved && $resolution == 'standard_resolution') checked @endif type="radio" name="resolution" value="standard_resolution">640x640</label>
                            </div>
                            <div class="low_resolution">
                                <img src="{{ asset('/vendor/shopify/instagram/images/size_resolution_2.png') }}" alt="">
                                <label><input @if ($setting_saved && $resolution == 'low_resolution') checked @endif type="radio" name="resolution" value="low_resolution">320x320</label>
                            </div>
                            <div class="thumbnail_resolution">
                                <img src="{{ asset('/vendor/shopify/instagram/images/size_resolution_2.png') }}" alt="">
                                <label><input @if ($setting_saved && $resolution == 'thumbnail') checked @elseif (!$setting_saved) checked @endif type="radio" name="resolution" value="thumbnail">150x150</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="column one-half">
                            <label><b>Number of Pictures:</b></label>
                            <input type="number" min="0" name="feed_limit" placeholder="feed limit" value="<?php echo ($feed_limit == false) ? 6 : $feed_limit ; ?>"><span><em>Max: 33</em></span>
                        </div>
                        <div class="column one-half">
                            <label><b>Space between pictures:</b></label>
                            <select name="space">
                                <option @if ($setting_saved && $space == 0) selected="selected" @endif value="0">0px</option>
                                <option @if ($setting_saved && $space == 2) selected="selected" @endif value="2">2px</option>
                                <option @if ($setting_saved && $space == 5) selected="selected" @elseif (!$setting_saved) selected="selected" @endif value="5">5px</option>
                                <option @if ($setting_saved && $space == 10) selected="selected" @endif value="10">10px</option>
                                <option @if ($setting_saved && $space == 25) selected="selected" @endif value="25">25px</option>
                                <option @if ($setting_saved && $space == 50) selected="selected" @endif value="50">50px</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="column one-half">
                            <label><b>Sort Pictures By:</b></label>
                            <select name="sortby">
                                <option @if ($setting_saved && $sortby == 'most-recent') selected="selected" @elseif (!$setting_saved) selected="selected" @endif value="most-recent">Newest to oldest</option>
                                <option @if ($setting_saved && $sortby == 'least-recent') selected="selected" @endif value="least-recent">Oldest to newest</option>
                                <option @if ($setting_saved && $sortby == 'most-liked') selected="selected" @endif value="most-liked">Highest # of likes to lowest</option>
                                <option @if ($setting_saved && $sortby == 'least-liked') selected="selected" @endif value="least-liked">Lowest # likes to highest</option>
                                <option @if ($setting_saved && $sortby == 'most-commented') selected="selected" @endif value="most-commented">Highest # of comments to lowest</option>
                                <option @if ($setting_saved && $sortby == 'least-commented') selected="selected" @endif value="least-commented">Lowest # of comments to highest</option>
                                <option @if ($setting_saved && $sortby == 'random') selected="selected" @endif value="random">Random order</option>
                            </select>
                        </div>
                        <div class="column one-half">
                            <label><b>When clicking on a picture:</b></label>
                            <select name="open_ig">
                                <option @if ($setting_saved && $open_ig == 1) selected="selected" @elseif (!$setting_saved) selected="selected" @endif value="1" selected="selected">Open Instagram</option>
                                <option @if ($setting_saved && $open_ig == 0) selected="selected" @endif value="0">Do nothing</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="column">
                            <label><b>Want to get instagram feed of other public user?, please enter user instagram id here:</b></label>
                            <input type="text" name="user_instagram_id" placeholder="user id" value="<?php echo ($user_instagram_id == false) ? '' : $user_instagram_id ; ?>">
                        </div>
                    </div>
                    <button type="submit">Save &amp; Preview</button>
                </form>
                {{--<button type="submit" id="publish" class="btn primary" disabled="">Publish to Store</button><br><br>--}}
                <div id="published-status-success" class="alert success" style="display: none;margin-top: 10px">
                    <dl>
                        <dt>Your setting have been saved successfully!</dt>

                    </dl>
                </div>
                <div id="published-status-warning" class="alert warning" style="display: none;margin-top: 10px">
                    <dl>
                        <dt>Save Failed. Please try again.</dt>

                    </dl>
                </div>
            </div>
            <div class="card columns one-half">
                <h5>Complete the installation</h5>
                Copy this code:
                <span class="tag grey">&lt;div id="instafeed"&gt;&lt;/div&gt;</span><br><br>
                Open your homepage file here: <a href="#" onclick="ShopifyApp.redirect('/themes/current/?key=templates/index.liquid');">index.liquid</a> and put the above line of code below all the existing code, press "Save" and you're done!<br><br>
                <br><br><h5>Having Trouble?</h5>
                For a full installation tutorial check this <a href="#" target="_blank">video</a> or read our <a id="installationUrl" href="#">Installation Guide</a>.<br><br> For troubleshooting read our <a id="faqUrl" href="#">FAQ</a> or send us an <a href="mailto:hi@cactusthemes.com">email</a>.
            </div>
        </section>
        <section class="full-width" style="padding: 18px 18px 0 18px;">
            <div class="card column twelve">
                <dl>
                    <dt>This is a preview of how your feed will look like:</dt>
                </dl>
                <div id="instafeed" class="column twelve" style="text-align: center;">

                </div>
                <button id="load-more" style="display: block; margin: auto">Load more</button>
            </div>
        </section>
    </main>


    <script type="text/javascript">
        $(document).ready(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("form").submit(function (e) {
                e.preventDefault(e);
                var data = $('form').serialize();
                $.ajax({
                    url: '{{ route( 'saveInstagramToken' ) }}',
                    data: data,
                    type: 'POST',
                    success: function (response) {
                        if (response == true) {
                            // check if token is valid
                            $("#published-status-success").show().delay(5000).fadeOut();
                            $('#instafeed').html('');
                            render_insta_feed();
                        } else {
                            $("#published-status-warning").show().delay(5000).fadeOut();
                        }
                    }
                });
            });

            function render_insta_feed() {
                var token = $("input[name='access_token']").val();
                var userID = token.split('.')[0];
                var resolution = $("input[name='resolution']:checked").val();
                var feed_limit = $("input[name='feed_limit']").val();
                var space = $("select[name='space'] option:selected").val();
                var sortby = $("select[name='sortby'] option:selected").val();
                var open_ig = $("select[name='open_ig'] option:selected").val();
                var user_instagram_id = $("input[name='user_instagram_id']").val();
                if (user_instagram_id != '') {
                    userID = user_instagram_id;
                }

                var open_tag = '{' + '{';
                var close_tag = '}' + '}';

                var image_size = 150;
                if (resolution == 'standard_resolution') {
                    image_size = 640;
                }

                if (resolution == 'low_resolution') {
                    image_size = 320;
                }

                if (resolution == 'thumbnail') {
                    image_size = 150;
                }
                var href = 'javascript:void(0)';
                if (open_ig == 1) {
                    href = open_tag + 'link' + close_tag;
                }

                // grab out load more button
                var loadButton = document.getElementById('load-more');

                var feed = new Instafeed({
                    get: 'user',
                    accessToken: token,
                    clientId: userID,
                    userId: userID,
                    resolution: resolution,
                    limit: feed_limit,
                    sortBy: sortby,
                    template: '<a href="' + href + '" target="_blank"><img style="object-fit:cover;margin:' + space + 'px;width:' + image_size + 'px;height:' + image_size + 'px;" title="' + open_tag + 'caption' + close_tag + '" src="' + open_tag + 'image' + close_tag + '" /></a>',
                    after: function() {
                        // disable button if no more results to load
                        if (!this.hasNext()) {
                            loadButton.setAttribute('disabled', 'disabled');
                        } else {
                            loadButton.removeAttribute("disabled");
                        }
                    }
                });

                // bind the load more button
                loadButton.addEventListener('click', function() {
                    feed.next();
                });

                feed.run();
            }

            if ($("input[name='access_token']").val() != '') {

                render_insta_feed();

            }
        });
    </script>
@endsection