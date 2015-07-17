<script src="/js/peer.min.js"></script>
<script src="/js/chat.js"></script>

    <div class="wrapper">
      <div class="row" id="video-box">
          <div class="six columns">
              <div id="your_video">
                  <video id="others-video" style="width:400px; height:300px;" autoplay controls poster="/img/other_poster.png"></video>
                  <ul>
                  <li><i class="icon-user"></i><span id="other-name2"></span></li>
                      <li><i class="icon-globe"></i><span id="other-country2"></span></li>
                      <li><i class="icon-comment"></i><span id="other-message2"></span></li>
                  </ul>
              </div>
          </div>
          <div class="six columns">
              <div id="my_video">
                  <video id="my-video" style="width:400px; height:300px;" autoplay controls poster="/img/my_poster.png"></video>
                  <ul>
                      <li><i class="icon-user"></i><span id="my-name"><?php echo $name;?></span></li>
                      <li><i class="icon-globe"></i><span id="my-country"><?php echo $country;?></span></li>
                      <li><i class="icon-comment"></i><span id="my-message"><?php echo $message;?></span></li>
                  </ul>
              </div>
          </div>
      </div>
      <div>
          <input type="hidden" id="peer-id" name="peer-id" value="" />
      </div>
    </div>

    <div class="modal" id="modal1">
        <div class="content">
            <a id="modal1-cancel" class="close switch" gumby-trigger="|#modal1"><i class="icon-cancel" /></i></a>
            <div class="row" id="modal-search">
                <div class="ten columns centered text-center">
                    <h2>Searching for a partner...</h2>
                    <p id="loading"><?php echo $this->Html->image('loading.gif');?></p>
                </div>
            </div>
            <div class="row" id="modal-found">
                <div class="ten columns centered text-center">
                    <h2>Partner found!</h2>
                    <p>This parner was found. Are you sure you want to talk to this person?</p>
                    <table>
                        <tbody>
                            <tr>
                                <td style="white-space:nowrap;"><i class="icon-user"></i>Name</td>
                                <td><span id="other-name"></span></td>
                            </tr>
                            <tr>
                                <td style="white-space:nowrap;"><i class="icon-globe"></i>Country</td>
                                <td><span id="other-country"></span></td>
                            </tr>
                            <tr>
                                <td style="white-space:nowrap;"><i class="icon-comment"></i>Message</td>
                                <td><span id="other-message"></span></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="btn primary medium answer-btn">
                        <a href="#" id="btn-ok"><i class="icon-check"></i>OK, Lets talking!</a>
                    </div>
                    <div class="btn info medium answer-btn">
                        <a href="#" id="btn-ng"><i class="icon-cancel"></i>No, I am sorry..</a>
                    </div>
                    <p class="answer-msg">Please wait a little...</p>
                </div>
            </div>
        </div>
    </div>

