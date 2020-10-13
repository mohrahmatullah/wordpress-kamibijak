window.current_time = 0;
window.ads_initialized = false;

/*videojs-youtube global define, YT*/
;(function (root, factory) {
  if(typeof exports==='object' && typeof module!=='undefined') {
    module.exports = factory(require('video.js'));
  } else if(typeof define === 'function' && define.amd) {
    define(['videojs'], function(videojs){
      return (root.Youtube = factory(videojs));
    });
  } else {
    root.Youtube = factory(root.videojs);
  }
}(this, function(videojs) {

  var Tech = videojs.getComponent('Tech');

  var Youtube = videojs.extend(Tech, {

    constructor: function(options, ready) {
      Tech.call(this, options, ready);

      this.setPoster(options.poster);
      this.setSrc(this.options_.source, true);

      // Set the vjs-youtube class to the player
      // Parent is not set yet so we have to wait a tick
      setTimeout(function() {
        this.el_.parentNode.className += ' vjs-youtube';

        if (_isOnMobile) {
          this.el_.parentNode.className += ' vjs-youtube-mobile';
        }

        if (Youtube.isApiReady) {
          this.initYTPlayer();
        } else {
          Youtube.apiReadyQueue.push(this);
        }
      }.bind(this));
    },

    dispose: function() {
      if (this.ytPlayer) {
        //Dispose of the YouTube Player
        this.ytPlayer.stopVideo();
        this.ytPlayer.destroy();
      } else {
        //YouTube API hasn't finished loading or the player is already disposed
        var index = Youtube.apiReadyQueue.indexOf(this);
        if (index !== -1) {
          Youtube.apiReadyQueue.splice(index, 1);
        }
      }
      this.ytPlayer = null;

      this.el_.parentNode.className = this.el_.parentNode.className
        .replace(' vjs-youtube', '')
        .replace(' vjs-youtube-mobile', '');
      // this.el_.remove();

      //Needs to be called after the YouTube player is destroyed, otherwise there will be a null reference exception
      Tech.prototype.dispose.call(this);
    },

    createEl: function() {
      var div = document.createElement('div');
      div.setAttribute('id', this.options_.techId);
      div.setAttribute('style', 'width:100%;height:100%;top:0;left:0;position:absolute');
      div.setAttribute('class', 'vjs-tech');

      var divWrapper = document.createElement('div');
      divWrapper.appendChild(div);

      if (!_isOnMobile && !this.options_.ytControls) {
        var divBlocker = document.createElement('div');
        divBlocker.setAttribute('class', 'vjs-iframe-blocker');
        divBlocker.setAttribute('style', 'position:absolute;top:0;left:0;width:100%;height:100%');

        // In case the blocker is still there and we want to pause
        divBlocker.onclick = function() {
          this.pause();
        }.bind(this);

        divWrapper.appendChild(divBlocker);
      }

      return divWrapper;
    },

    initYTPlayer: function() {
      var playerVars = {
        controls: 0,
        modestbranding: 1,
        rel: 0,
        showinfo: 0,
        loop: this.options_.loop ? 1 : 0
      };

      // Let the user set any YouTube parameter
      // https://developers.google.com/youtube/player_parameters?playerVersion=HTML5#Parameters
      // To use YouTube controls, you must use ytControls instead
      // To use the loop or autoplay, use the video.js settings

      if (typeof this.options_.autohide !== 'undefined') {
        playerVars.autohide = this.options_.autohide;
      }

      if (typeof this.options_['cc_load_policy'] !== 'undefined') {
        playerVars['cc_load_policy'] = this.options_['cc_load_policy'];
      }

      if (typeof this.options_.ytControls !== 'undefined') {
        playerVars.controls = this.options_.ytControls;
      }

      if (typeof this.options_.disablekb !== 'undefined') {
        playerVars.disablekb = this.options_.disablekb;
      }

      if (typeof this.options_.end !== 'undefined') {
        playerVars.end = this.options_.end;
      }

      if (typeof this.options_.color !== 'undefined') {
        playerVars.color = this.options_.color;
      }

      if (!playerVars.controls) {
        // Let video.js handle the fullscreen unless it is the YouTube native controls
        playerVars.fs = 0;
      } else if (typeof this.options_.fs !== 'undefined') {
        playerVars.fs = this.options_.fs;
      }

      if (typeof this.options_.end !== 'undefined') {
        playerVars.end = this.options_.end;
      }

      if (typeof this.options_.hl !== 'undefined') {
        playerVars.hl = this.options_.hl;
      } else if (typeof this.options_.language !== 'undefined') {
        // Set the YouTube player on the same language than video.js
        playerVars.hl = this.options_.language.substr(0, 2);
      }

      if (typeof this.options_['iv_load_policy'] !== 'undefined') {
        playerVars['iv_load_policy'] = this.options_['iv_load_policy'];
      }

      if (typeof this.options_.list !== 'undefined') {
        playerVars.list = this.options_.list;
      } else if (this.url && typeof this.url.listId !== 'undefined') {
        playerVars.list = this.url.listId;
      }

      if (typeof this.options_.listType !== 'undefined') {
        playerVars.listType = this.options_.listType;
      }

      if (typeof this.options_.modestbranding !== 'undefined') {
        playerVars.modestbranding = this.options_.modestbranding;
      }

      if (typeof this.options_.playlist !== 'undefined') {
        playerVars.playlist = this.options_.playlist;
      }

      if (typeof this.options_.playsinline !== 'undefined') {
        playerVars.playsinline = this.options_.playsinline;
      }

      if (typeof this.options_.rel !== 'undefined') {
        playerVars.rel = this.options_.rel;
      }

      if (typeof this.options_.showinfo !== 'undefined') {
        playerVars.showinfo = this.options_.showinfo;
      }

      if (typeof this.options_.start !== 'undefined') {
        playerVars.start = this.options_.start;
      }

      if (typeof this.options_.theme !== 'undefined') {
        playerVars.theme = this.options_.theme;
      }

      this.activeVideoId = this.url ? this.url.videoId : null;
      this.activeList = playerVars.list;

      this.ytPlayer = new YT.Player(this.options_.techId, {
        videoId: this.activeVideoId,
        playerVars: playerVars,
        events: {
          onReady: this.onPlayerReady.bind(this),
          onPlaybackQualityChange: this.onPlayerPlaybackQualityChange.bind(this),
          onStateChange: this.onPlayerStateChange.bind(this),
          onError: this.onPlayerError.bind(this)
        }
      });
    },

    onPlayerReady: function() {
      this.playerReady_ = true;
      this.triggerReady();

      if (this.playOnReady) {
        this.play();
      } else if (this.cueOnReady) {
        this.ytPlayer.cueVideoById(this.url.videoId);
        this.activeVideoId = this.url.videoId;
      }
    },

    onPlayerPlaybackQualityChange: function() {

    },

    onPlayerStateChange: function(e) {
      var state = e.data;

      if (state === this.lastState || this.errorNumber) {
        return;
      }
      //update state only for playlist videos. otherwise state conflict is caused, and youtube video is being paused
      if( jQuery('body').hasClass('playlist-enabled') ) {
        this.lastState = state;
      }

      switch (state) {
        case -1:
          this.trigger('loadstart');
          this.trigger('loadedmetadata');
          this.trigger('durationchange');
          break;

        case YT.PlayerState.ENDED:
          this.trigger('ended');
          break;

        case YT.PlayerState.PLAYING:
          this.trigger('timeupdate');
          this.trigger('durationchange');
          this.trigger('playing');
          this.trigger('play');

          if (this.isSeeking) {
            this.onSeeked();
          }
          break;

        case YT.PlayerState.PAUSED:
          this.trigger('canplay');
          if (this.isSeeking) {
            this.onSeeked();
          } else {
            this.trigger('pause');
          }
          break;

        case YT.PlayerState.BUFFERING:
          this.player_.trigger('timeupdate');
          this.player_.trigger('waiting');
          break;
      }
    },

    onPlayerError: function(e) {
      this.errorNumber = e.data;
      this.trigger('error');

      this.ytPlayer.stopVideo();
    },

    error: function() {
      switch (this.errorNumber) {
        case 5:
          return { code: 'Error while trying to play the video' };

        case 2:
        case 100:
          return { code: 'Unable to find the video' };

        case 101:
        case 150:
          return { code: 'Playback on other Websites has been disabled by the video owner.' };
      }

      return { code: 'YouTube unknown error (' + this.errorNumber + ')' };
    },

    src: function(src) {
      if (src) {
        this.setSrc({ src: src });
      }

      return this.source;
    },

    poster: function() {
      // You can't start programmaticlly a video with a mobile
      // through the iframe so we hide the poster and the play button (with CSS)
      if (_isOnMobile) {
        return null;
      }

      return this.poster_;
    },

    setPoster: function(poster) {
      this.poster_ = poster;
    },

    setSrc: function(source) {
      if (!source || !source.src) {
        return;
      }

      delete this.errorNumber;
      this.source = source;
      this.url = Youtube.parseUrl(source.src);

      if (!this.options_.poster) {
        if (this.url.videoId) {
          // Set the low resolution first
          this.poster_ = 'https://img.youtube.com/vi/' + this.url.videoId + '/0.jpg';
          this.trigger('posterchange');

          // Check if their is a high res
          this.checkHighResPoster();
        }
      }

      if (this.options_.autoplay && !_isOnMobile) {
        if (this.isReady_) {
          this.play();
        } else {
          this.playOnReady = true;
        }
      } else if (this.activeVideoId !== this.url.videoId) {
        if (this.isReady_) {
          this.ytPlayer.cueVideoById(this.url.videoId);
          this.activeVideoId = this.url.videoId;
        } else {
          this.cueOnReady = true;
        }
      }
    },

    autoplay: function() {
      return this.options_.autoplay;
    },

    setAutoplay: function(val) {
      this.options_.autoplay = val;
    },

    loop: function() {
      return this.options_.loop;
    },

    setLoop: function(val) {
      this.options_.loop = val;
    },

    play: function() {
      if (!this.url || !this.url.videoId) {
        return;
      }

      this.wasPausedBeforeSeek = false;

      if (this.isReady_) {
        if (this.url.listId) {
          if (this.activeList === this.url.listId) {
            this.ytPlayer.playVideo();
          } else {
            this.ytPlayer.loadPlaylist(this.url.listId);
            this.activeList = this.url.listId;
          }
        }

        if (this.activeVideoId === this.url.videoId) {
          this.ytPlayer.playVideo();
        } else {
          this.ytPlayer.loadVideoById(this.url.videoId);
          this.activeVideoId = this.url.videoId;
        }
      } else {
        this.trigger('waiting');
        this.playOnReady = true;
      }
    },

    pause: function() {
      if (this.ytPlayer) {
        this.ytPlayer.pauseVideo();
      }
    },

    paused: function() {
      return (this.ytPlayer) ?
        (this.lastState !== YT.PlayerState.PLAYING && this.lastState !== YT.PlayerState.BUFFERING)
        : true;
    },

    currentTime: function() {
      return this.ytPlayer ? this.ytPlayer.getCurrentTime() : 0;
    },

    setCurrentTime: function(seconds) {
      if (this.lastState === YT.PlayerState.PAUSED) {
        this.timeBeforeSeek = this.currentTime();
      }

      if (!this.isSeeking) {
        this.wasPausedBeforeSeek = this.paused();
      }

      this.ytPlayer.seekTo(seconds, true);
      this.trigger('timeupdate');
      this.trigger('seeking');
      this.isSeeking = true;

      // A seek event during pause does not return an event to trigger a seeked event,
      // so run an interval timer to look for the currentTime to change
      if (this.lastState === YT.PlayerState.PAUSED && this.timeBeforeSeek !== seconds) {
        clearInterval(this.checkSeekedInPauseInterval);
        this.checkSeekedInPauseInterval = setInterval(function() {
          if (this.lastState !== YT.PlayerState.PAUSED || !this.isSeeking) {
            // If something changed while we were waiting for the currentTime to change,
            //  clear the interval timer
            clearInterval(this.checkSeekedInPauseInterval);
          } else if (this.currentTime() !== this.timeBeforeSeek) {
            this.trigger('timeupdate');
            this.onSeeked();
          }
        }.bind(this), 250);
      }
    },

    seeking: function () {
      return this.isSeeking;
    },

    seekable: function () {
      if(!this.ytPlayer || !this.ytPlayer.getVideoLoadedFraction) {
        return {
          length: 0,
          start: function() {
            throw new Error('This TimeRanges object is empty');
          },
          end: function() {
            throw new Error('This TimeRanges object is empty');
          }
        };
      }
      var end = this.ytPlayer.getDuration();

      return {
        length: this.ytPlayer.getDuration(),
        start: function() { return 0; },
        end: function() { return end; }
      };
    },

    onSeeked: function() {
      clearInterval(this.checkSeekedInPauseInterval);
      this.isSeeking = false;

      if (this.wasPausedBeforeSeek) {
        this.pause();
      }

      this.trigger('seeked');
    },

    playbackRate: function() {
      return this.ytPlayer ? this.ytPlayer.getPlaybackRate() : 1;
    },

    setPlaybackRate: function(suggestedRate) {
      if (!this.ytPlayer) {
        return;
      }

      this.ytPlayer.setPlaybackRate(suggestedRate);
      this.trigger('ratechange');
    },

    duration: function() {
      return this.ytPlayer ? this.ytPlayer.getDuration() : 0;
    },

    currentSrc: function() {
      return this.source && this.source.src;
    },

    ended: function() {
      return this.ytPlayer ? (this.lastState === YT.PlayerState.ENDED) : false;
    },

    volume: function() {
      return this.ytPlayer ? this.ytPlayer.getVolume() / 100.0 : 1;
    },

    setVolume: function(percentAsDecimal) {
      if (!this.ytPlayer) {
        return;
      }

      this.ytPlayer.setVolume(percentAsDecimal * 100.0);
      this.setTimeout( function(){
        this.trigger('volumechange');
      }, 50);

    },

    muted: function() {
      return this.ytPlayer ? this.ytPlayer.isMuted() : false;
    },

    setMuted: function(mute) {
      if (!this.ytPlayer) {
        return;
      }
      else{
        this.muted(true);
      }

      if (mute) {
        this.ytPlayer.mute();
      } else {
        this.ytPlayer.unMute();
      }
      this.setTimeout( function(){
        this.trigger('volumechange');
      }, 50);
    },

    buffered: function() {
      if(!this.ytPlayer || !this.ytPlayer.getVideoLoadedFraction) {
        return {
          length: 0,
          start: function() {
            throw new Error('This TimeRanges object is empty');
          },
          end: function() {
            throw new Error('This TimeRanges object is empty');
          }
        };
      }

      var end = this.ytPlayer.getVideoLoadedFraction() * this.ytPlayer.getDuration();

      return {
        length: this.ytPlayer.getDuration(),
        start: function() { return 0; },
        end: function() { return end; }
      };
    },

    // TODO: Can we really do something with this on YouTUbe?
    preload: function() {},
    load: function() {},
    reset: function() {},

    supportsFullScreen: function() {
      return true;
    },

    // Tries to get the highest resolution thumbnail available for the video
    checkHighResPoster: function(){
      var uri = 'https://img.youtube.com/vi/' + this.url.videoId + '/maxresdefault.jpg';

      try {
        var image = new Image();
        image.onload = function(){
          // Onload may still be called if YouTube returns the 120x90 error thumbnail
          if('naturalHeight' in image){
            if (image.naturalHeight <= 90 || image.naturalWidth <= 120) {
              return;
            }
          } else if(image.height <= 90 || image.width <= 120) {
            return;
          }

          this.poster_ = uri;
          this.trigger('posterchange');
        }.bind(this);
        image.onerror = function(){};
        image.src = uri;
      }
      catch(e){}
    }
  });

  Youtube.isSupported = function() {
    return true;
  };

  Youtube.canPlaySource = function(e) {
    return Youtube.canPlayType(e.type);
  };

  Youtube.canPlayType = function(e) {
    return (e === 'video/youtube');
  };

  var _isOnMobile = videojs.browser.IS_IOS || useNativeControlsOnAndroid();

  Youtube.parseUrl = function(url) {
    var result = {
      videoId: null
    };

    var regex = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
    var match = url.match(regex);

    if (match && match[2].length === 11) {
      result.videoId = match[2];
    }

    var regPlaylist = /[?&]list=([^#\&\?]+)/;
    match = url.match(regPlaylist);

    if(match && match[1]) {
      result.listId = match[1];
    }

    return result;
  };

  function apiLoaded() {
    YT.ready(function() {
      Youtube.isApiReady = true;

      for (var i = 0; i < Youtube.apiReadyQueue.length; ++i) {
        Youtube.apiReadyQueue[i].initYTPlayer();
      }
    });
  }

  function loadScript(src, callback) {
    var loaded = false;
    var tag = document.createElement('script');
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    tag.onload = function () {
      if (!loaded) {
        loaded = true;
        callback();
      }
    };
    tag.onreadystatechange = function () {
      if (!loaded && (this.readyState === 'complete' || this.readyState === 'loaded')) {
        loaded = true;
        callback();
      }
    };
    tag.src = src;
  }

  function injectCss() {
    var css = // iframe blocker to catch mouse events
              '.vjs-youtube .vjs-iframe-blocker { display: none; }' +
              '.vjs-youtube.vjs-user-inactive .vjs-iframe-blocker { display: block; }' +
              '.vjs-youtube .vjs-poster { background-size: cover; }' +
              '.vjs-youtube-mobile .vjs-big-play-button { display: none; }';

    var head = document.head || document.getElementsByTagName('head')[0];

    var style = document.createElement('style');
    style.type = 'text/css';

    if (style.styleSheet){
      style.styleSheet.cssText = css;
    } else {
      style.appendChild(document.createTextNode(css));
    }

    head.appendChild(style);
  }

  function useNativeControlsOnAndroid() {
    var stockRegex = window.navigator.userAgent.match(/applewebkit\/(\d*).*Version\/(\d*.\d*)/i);
    //True only Android Stock Browser on OS versions 4.X and below
    //where a Webkit version and a "Version/X.X" String can be found in
    //user agent.
    return videojs.browser.IS_ANDROID && videojs.browser.ANDROID_VERSION < 5 && stockRegex && stockRegex[2] > 0;
  }

  Youtube.apiReadyQueue = [];

  loadScript('https://www.youtube.com/iframe_api', apiLoaded);
  injectCss();

  // Older versions of VJS5 doesn't have the registerTech function
  if (typeof videojs.registerTech !== 'undefined') {

    videojs.registerTech('Youtube', Youtube);

  } else {

    videojs.registerComponent('Youtube', Youtube);

  }

}));
/*
  videojs-vimeo
  https://github.com/hendrathings/videojs-vimeo/blob/bug-api/src/Vimeo.js
 */

(function() {

  var VimeoState = {
    UNSTARTED: -1,
    ENDED: 0,
    PLAYING: 1,
    PAUSED: 2,
    BUFFERING: 3
  };

  var Tech = videojs.getComponent('Tech');

  var Vimeo = videojs.extend(Tech, {
    constructor: function(options, ready) {
      Tech.call(this, options, ready);
      if(options.poster != "") {this.setPoster(options.poster);}
      this.setSrc(this.options_.source.src, true);

      // Set the vjs-vimeo class to the player
      // Parent is not set yet so we have to wait a tick
      setTimeout(function() {
        this.el_.parentNode.className += ' vjs-vimeo';
        
        if (Vimeo.isApiReady) {
          this.initPlayer();
        } else {
          Vimeo.apiReadyQueue.push(this);
        }
      }.bind(this));
      
    },
    
    dispose: function() {
      this.el_.parentNode.className = this.el_.parentNode.className.replace(' vjs-vimeo', '');
      this.el_.remove();
      if (this.vimeo && this.vimeo.api) {
        this.vimeo.api('unload');
        delete this.vimeo;
      }

      this.vimeo = null;
      Tech.prototype.dispose.call(this);  

    },
    
    createEl: function() {
      this.vimeo = {};
      this.vimeoInfo = {};
      this.baseUrl = 'https://player.vimeo.com/video/';
      this.baseApiUrl = 'http://www.vimeo.com/api/v2/video/';
      this.videoId = Vimeo.parseUrl(this.options_.source.src).videoId;
      
      this.iframe = document.createElement('iframe');
      this.iframe.setAttribute('id', this.options_.techId);
      this.iframe.setAttribute('title', 'Vimeo Video Player');
      this.iframe.setAttribute('class', 'vimeoplayer');
      this.iframe.setAttribute('src', this.baseUrl + this.videoId + '?api=1&player_id=' + this.options_.techId);
      this.iframe.setAttribute('frameborder', '0');
      this.iframe.setAttribute('scrolling', 'no');
      this.iframe.setAttribute('marginWidth', '0');
      this.iframe.setAttribute('marginHeight', '0');
      this.iframe.setAttribute('webkitAllowFullScreen', '0');
      this.iframe.setAttribute('mozallowfullscreen', '0');
      this.iframe.setAttribute('allowFullScreen', '0');

      var divWrapper = document.createElement('div');
      divWrapper.setAttribute('style', 'width:100%; height:100%; overflow:hidden; margin:0 auto;');
      divWrapper.appendChild(this.iframe);

      if (!_isOnMobile && !this.options_.ytControls) {
        var divBlocker = document.createElement('div');
        divBlocker.setAttribute('class', 'vjs-iframe-blocker');
        divBlocker.setAttribute('style', 'position:absolute;top:0;left:0;width:100%;height:100%');

        // In case the blocker is still there and we want to pause
        divBlocker.onclick = function() {
          this.onPause();
        }.bind(this);

        divWrapper.appendChild(divBlocker);
      }
      
      if(this.options_.poster == "" && this.videoId != null) {
        jQuery.getJSON(this.baseApiUrl + this.videoId + '.json?callback=?', {format: "json"}, (function(_this){
          return function(data) {
            // Set the low resolution first
            _this.setPoster(data[0].thumbnail_large);
          };
        })(this));
      }

      return divWrapper;
    },
    
    initPlayer: function() {
      var self = this;
      
      jQuery(self.iframe).load(function(){
        var vimeoVideoID = Vimeo.parseUrl(self.options_.source.src).videoId;
        //load vimeo
        if (self.vimeo && self.vimeo.api) {
          self.vimeo.api('unload');
          delete self.vimeo;
        }
        
        self.vimeo = $f(self.iframe);
        
        self.vimeoInfo = {
          state: VimeoState.UNSTARTED,
          volume: 1,
          muted: false,
          muteVolume: 1,
          time: 0,
          duration: 0,
          buffered: 0,
          url: self.baseUrl + self.videoId,
          error: null,
          controls: 0
        };

        self.vimeo.addEvent('ready', function(id){
          self.onReady();

          self.vimeo.addEvent('loadProgress', function(data, id){ self.onLoadProgress(data); });
          self.vimeo.addEvent('playProgress', function(data, id){ self.onPlayProgress(data); });
          self.vimeo.addEvent('play', function(id){ self.onPlay(); });
          self.vimeo.addEvent('pause', function(id){ self.onPause(); });
          self.vimeo.addEvent('finish', function(id){ self.onFinish(); });
          self.vimeo.addEvent('seek', function(data, id){ self.onSeek(data); });

        });
      });
      
    },
    
    onReady: function(){
      this.playerReady_ = true;
      this.triggerReady();
      this.trigger('loadedmetadata');
      if (this.startMuted) {
        this.setMuted(true);
        this.startMuted = false;
      }
    },
    
    onLoadProgress: function(data) {
      var durationUpdate = !this.vimeoInfo.duration;
      this.vimeoInfo.duration = data.duration;
      this.vimeoInfo.buffered = data.percent;
      this.trigger('progress');
      if (durationUpdate) this.trigger('durationchange');
    },
    onPlayProgress: function(data) {
      this.vimeoInfo.time = data.seconds;
      this.trigger('timeupdate');
      this.trigger('durationchange');
      this.trigger('playing');
      this.trigger('play');
    },
    onPlay: function() {
      this.vimeoInfo.state = VimeoState.PLAYING;
      this.trigger('play');
    },
    onPause: function() {
      this.vimeoInfo.state = VimeoState.PAUSED;
      this.trigger('pause');
    },
    onFinish: function() {
      this.vimeoInfo.state = VimeoState.ENDED;
      this.trigger('ended');
    },
    onSeek: function(data) {
      this.trigger('seeking');
      this.vimeoInfo.time = data.seconds;
      this.trigger('timeupdate');
      this.trigger('seeked');
    },
    onError: function(error){
      this.error = error;
      this.trigger('error');
    },
    
    error: function() {
      switch (this.errorNumber) {
        case 2:
          return { code: 'Unable to find the video' };

        case 5:
          return { code: 'Error while trying to play the video' };

        case 100:
          return { code: 'Unable to find the video' };

        case 101:
        case 150:
          return { code: 'Playback on other Websites has been disabled by the video owner.' };
      }

      return { code: 'Vimeo unknown error (' + this.errorNumber + ')' };
    },
    
    src: function() {
      return this.source;
    },

    poster: function() {
      return this.poster_;
    },

    setPoster: function(poster) {
      this.poster_ = poster;
    },

    setSrc: function(source) {
      if (!source || !source.src) {
        return;
      }

      this.source = source;
      this.url = Vimeo.parseUrl(source.src);

      if (!this.options_.poster && this.url.videoId != null) {
          jQuery.getJSON(this.baseApiUrl + this.videoId + '.json?callback=?', {format: "json"}, (function(_this){
            return function(data) {
              // Set the low resolution first
              _this.poster_ = data[0].thumbnail_small;
            };
          })(this));

          // Check if their is a high res
          this.checkHighResPoster();
      }

      if (this.options_.autoplay && !_isOnMobile) {
        if (this.isReady_) {
          this.play();
        } else {
          this.playOnReady = true;
        }
      }
    },
    
    supportsFullScreen: function() {
      return true;
    },
    
    //TRIGGER
    load : function(){},
    play : function(){ this.vimeo.api('play'); },
    pause : function(){ this.vimeo.api('pause'); },
    paused : function(){
      return this.vimeoInfo.state !== VimeoState.PLAYING &&
             this.vimeoInfo.state !== VimeoState.BUFFERING;
    },

    ended: function(){
      return this.vimeoInfo.state === VimeoState.ENDED;
    },

    currentTime : function(){ return this.vimeoInfo.time || 0; },

    setCurrentTime :function(seconds){
      this.vimeo.api('seekTo', seconds);
      this.player_.trigger('timeupdate');
    },

    duration :function(){ return this.vimeoInfo.duration || 0; },
    buffered :function(){ return videojs.createTimeRange(0, (this.vimeoInfo.buffered*this.vimeoInfo.duration) || 0); },

    volume :function() { return (this.vimeoInfo.muted)? this.vimeoInfo.muteVolume : this.vimeoInfo.volume; },
    setVolume :function(percentAsDecimal){
      this.vimeo.api('setvolume', percentAsDecimal);
      this.vimeoInfo.volume = percentAsDecimal;
      this.player_.trigger('volumechange');
    },
    currentSrc :function() {
      return this.el_.src;
    },
    muted :function() { return this.vimeoInfo.muted || false; },
    setMuted :function(muted) {
      if (muted) {
        this.vimeoInfo.muteVolume = this.vimeoInfo.volume;
        this.setVolume(0);
      } else {
        this.setVolume(this.vimeoInfo.muteVolume);
      }

      this.vimeoInfo.muted = muted;
      this.player_.trigger('volumechange');
    },

    // Tries to get the highest resolution thumbnail available for the video
    checkHighResPoster: function(){
      var uri = '';

      try {
        if(this.url.videoId != null){
          jQuery.getJSON(this.baseApiUrl + this.videoId + '.json?callback=?', {format: "json"}, (function(_uri){
            return function(data) {
              // Set the low resolution first
              _uri = data[0].thumbnail_large;
            };
          })(uri));
          
          var image = new Image();
          image.onload = function(){
            // Onload thumbnail
            if('naturalHeight' in this){
              if(this.naturalHeight <= 90 || this.naturalWidth <= 120) {
                this.onerror();
                return;
              }
            } else if(this.height <= 90 || this.width <= 120) {
              this.onerror();
              return;
            }

            this.poster_ = uri;
            this.trigger('posterchange');
          }.bind(this);
          image.onerror = function(){};
          image.src = uri;
        }
      }
      catch(e){}
    }
  });

  Vimeo.isSupported = function() {
    return true;
  };

  Vimeo.canPlaySource = function(e) {
    return (e.type === 'video/vimeo');
  };

  var _isOnMobile = /(iPad|iPhone|iPod|Android)/g.test(navigator.userAgent);

  Vimeo.parseUrl = function(url) {
    var result = {
      videoId: null
    };

    var regex = /^.*(vimeo\.com\/)((channels\/[A-z]+\/)|(groups\/[A-z]+\/videos\/))?([0-9]+)/;
    var match = url.match(regex);

    if (match) {
      result.videoId = match[5];
    }

    return result;
  };

  function injectCss() {
    var css = // iframe blocker to catch mouse events
              '.vjs-vimeo { overflow: hidden }' +
              '.vjs-vimeo .vjs-iframe-blocker { display: none; }' +
              '.vjs-vimeo.vjs-user-inactive .vjs-iframe-blocker { display: block; }' +
              '.vimeoplayer {display:block; width:100%; height:100%; margin:0 auto;}';

    var head = document.head || document.getElementsByTagName('head')[0];

    var style = document.createElement('style');
    style.type = 'text/css';

    if (style.styleSheet){
      style.styleSheet.cssText = css;
    } else {
      style.appendChild(document.createTextNode(css));
    }

    head.appendChild(style);
  }

  Vimeo.apiReadyQueue = [];

  var vimeoIframeAPIReady = function() {
    Vimeo.isApiReady = true;
    injectCss();

    for (var i = 0; i < Vimeo.apiReadyQueue.length; ++i) {
      Vimeo.apiReadyQueue[i].initPlayer();
    }
  };

  vimeoIframeAPIReady();

  videojs.registerTech('Vimeo', Vimeo);
  
  
  
  // Froogaloop API -------------------------------------------------------------

  // From https://github.com/vimeo/player-api/blob/master/javascript/froogaloop.js
  // Init style shamelessly stolen from jQuery http://jquery.com
  var Froogaloop = (function(){
      // Define a local copy of Froogaloop
      function Froogaloop(iframe) {
          // The Froogaloop object is actually just the init constructor
          return new Froogaloop.fn.init(iframe);
      }

      var eventCallbacks = {},
          hasWindowEvent = false,
          isReady = false,
          slice = Array.prototype.slice,
          playerOrigin = '*';

      Froogaloop.fn = Froogaloop.prototype = {
          element: null,

          init: function(iframe) {
              if (typeof iframe === "string") {
                  iframe = document.getElementById(iframe);
              }

              this.element = iframe;

              return this;
          },

          /*
           * Calls a function to act upon the player.
           *
           * @param {string} method The name of the Javascript API method to call. Eg: 'play'.
           * @param {Array|Function} valueOrCallback params Array of parameters to pass when calling an API method
           *                                or callback function when the method returns a value.
           */
          api: function(method, valueOrCallback) {
              if (!this.element || !method) {
                  return false;
              }

              var self = this,
                  element = self.element,
                  target_id = element.id !== '' ? element.id : null,
                  params = !isFunction(valueOrCallback) ? valueOrCallback : null,
                  callback = isFunction(valueOrCallback) ? valueOrCallback : null;

              // Store the callback for get functions
              if (callback) {
                  storeCallback(method, callback, target_id);
              }

              postMessage(method, params, element);
              return self;
          },

          /*
           * Registers an event listener and a callback function that gets called when the event fires.
           *
           * @param eventName (String): Name of the event to listen for.
           * @param callback (Function): Function that should be called when the event fires.
           */
          addEvent: function(eventName, callback) {
              if (!this.element) {
                  return false;
              }

              var self = this,
                  element = self.element,
                  target_id = element.id !== '' ? element.id : null;


              storeCallback(eventName, callback, target_id);

              // The ready event is not registered via postMessage. It fires regardless.
              if (eventName != 'ready') {
                  postMessage('addEventListener', eventName, element);
              }
              else if (eventName == 'ready' && isReady) {
                  callback.call(null, target_id);
              }

              return self;
          },

          /*
           * Unregisters an event listener that gets called when the event fires.
           *
           * @param eventName (String): Name of the event to stop listening for.
           */
          removeEvent: function(eventName) {
              if (!this.element) {
                  return false;
              }

              var self = this,
                  element = self.element,
                  target_id = element.id !== '' ? element.id : null,
                  removed = removeCallback(eventName, target_id);

              // The ready event is not registered
              if (eventName != 'ready' && removed) {
                  postMessage('removeEventListener', eventName, element);
              }
          }
      };

      /**
       * Handles posting a message to the parent window.
       *
       * @param method (String): name of the method to call inside the player. For api calls
       * this is the name of the api method (api_play or api_pause) while for events this method
       * is api_addEventListener.
       * @param params (Object or Array): List of parameters to submit to the method. Can be either
       * a single param or an array list of parameters.
       * @param target (HTMLElement): Target iframe to post the message to.
       */
      function postMessage(method, params, target) {
          if (target.contentWindow == null || !target.contentWindow.postMessage) {
              return false;
          }

          var data = JSON.stringify({
              method: method,
              value: params
          });

          target.contentWindow.postMessage(data, playerOrigin);
      }

      /**
       * Event that fires whenever the window receives a message from its parent
       * via window.postMessage.
       */
      function onMessageReceived(event) {
          var data, method;

          try {
              data = JSON.parse(event.data);
              method = data.event || data.method;
          }
          catch(e)  {
              //fail silently... like a ninja!
          }

          if (method == 'ready' && !isReady) {
              isReady = true;
          }

          // Handles messages from the vimeo player only
          if (!(/^https?:\/\/player.vimeo.com/).test(event.origin)) {
              return false;
          }

          if (playerOrigin === '*') {
              playerOrigin = event.origin;
          }

          var value = data.value,
              eventData = data.data,
              target_id = target_id === '' ? null : data.player_id,

              callback = getCallback(method, target_id),
              params = [];

          if (!callback) {
              return false;
          }

          if (value !== undefined) {
              params.push(value);
          }

          if (eventData) {
              params.push(eventData);
          }

          if (target_id) {
              params.push(target_id);
          }

          return params.length > 0 ? callback.apply(null, params) : callback.call();
      }


      /**
       * Stores submitted callbacks for each iframe being tracked and each
       * event for that iframe.
       *
       * @param eventName (String): Name of the event. Eg. api_onPlay
       * @param callback (Function): Function that should get executed when the
       * event is fired.
       * @param target_id (String) [Optional]: If handling more than one iframe then
       * it stores the different callbacks for different iframes based on the iframe's
       * id.
       */
      function storeCallback(eventName, callback, target_id) {
          if (target_id) {
              if (!eventCallbacks[target_id]) {
                  eventCallbacks[target_id] = {};
              }
              eventCallbacks[target_id][eventName] = callback;
          }
          else {
              eventCallbacks[eventName] = callback;
          }
      }

      /**
       * Retrieves stored callbacks.
       */
      function getCallback(eventName, target_id) {
          if (target_id && eventCallbacks[target_id]) {
              return eventCallbacks[target_id][eventName];
          }
          else if (eventCallbacks[eventName]) {
              return eventCallbacks[eventName];
          }
      }

      function removeCallback(eventName, target_id) {
          if (target_id && eventCallbacks[target_id]) {
              if (!eventCallbacks[target_id][eventName]) {
                  return false;
              }
              eventCallbacks[target_id][eventName] = null;
          }
          else {
              if (!eventCallbacks[eventName]) {
                  return false;
              }
              eventCallbacks[eventName] = null;
          }

          return true;
      }

      function isFunction(obj) {
          return !!(obj && obj.constructor && obj.call && obj.apply);
      }

      function isArray(obj) {
          return toString.call(obj) === '[object Array]';
      }

      // Give the init function the Froogaloop prototype for later instantiation
      Froogaloop.fn.init.prototype = Froogaloop.fn;

      // Listens for the message event.
      // W3C
      if (window.addEventListener) {
          window.addEventListener('message', onMessageReceived, false);
      }
      // IE
      else {
          window.attachEvent('onmessage', onMessageReceived);
      }

      // Expose froogaloop to the global object
      return (window.Froogaloop = window.$f = Froogaloop);

  })();
})();

/*
 * Vast plugin
 */

(function(window, videojs, vast) {
  var extend = function(obj) {
    var arg, i, k;
    for (i = 1; i < arguments.length; i++) {
      arg = arguments[i];
      for (k in arg) {
        if (arg.hasOwnProperty(k)) {
          obj[k] = arg[k];
        }
      }
    }
    return obj;
  },

  defaults = {
    // seconds before skip button shows, negative values to disable skip button altogether
    skip: 5
  },

  Vast = function (player, settings) {

    // return vast plugin
    return {
      createSourceObjects: function (media_files) {

        var sourcesByFormat = {}, i, j, tech;
        var techOrder = player.options().techOrder;

        tech = videojs.getTech('Html5');

        var source =  {
          src: settings.src,
          type: "video/mp4"
        };

        var sources2 = [];

        sources2[0] = source;

        return sources2;
      },

      getContent: function () {

        // query vast url given in settings
        player.vast.sources = player.vast.createSourceObjects();
        player.vast.companion = undefined;


        if (!player.vastTracker) {
          // No pre-roll, start video
          player.trigger('adsready');
          player.trigger('adscanceled');
        }

        player.vastTracker = true;

      },

      setupEvents: function() {

        var errorOccurred = false,
          canplayFn = function(){
          },
          timeupdateFn = function(){
          },
          pauseFn = function(){
          },
          errorFn = function(){
            // Inform ad server we couldn't play the media file for this ad
            errorOccurred = true;
            player.trigger('ended');
          };

        player.on('canplay', canplayFn);
        player.on('timeupdate', timeupdateFn);
        player.on('pause', pauseFn);
        player.on('error', errorFn);

        player.one('vast-preroll-removed', function() {
          player.off('canplay', canplayFn);
          player.off('timeupdate', timeupdateFn);
          player.off('pause', pauseFn);
          player.off('error', errorFn);
          
        });
      },

      preroll: function() {

        player.ads.startLinearAdMode();
        player.vast.showControls = player.controls();
        if (player.vast.showControls) {
          player.controls(false);
        }

        // load linear ad sources and start playing them
        player.src(player.vast.sources);

        var clickthrough = settings.url;      

        var blocker = window.document.createElement("a");
            blocker.className = "vast-blocker";
            blocker.href = clickthrough || "#";
            blocker.target = "_blank";

            blocker.setAttribute('data-key', settings.key);

        AIRKIT.setVideoAdStats.init('views', settings.key);

        blocker.onclick = function() {

          if ( player.paused() ) {
            player.play();
            return false;
          }

          // Here is the pre-roll views click counter
          AIRKIT.setVideoAdStats.init('clicks', settings.key);

          player.trigger("adclick");

        };

        player.vast.blocker = blocker;
        player.el().insertBefore(blocker, player.controlBar.el());

        var skipButton = window.document.createElement("div");
            skipButton.className = "vast-skip-button";
            skipButton.innerHTML = 'Skip';

        if ( settings.skip == false ) {
          skipButton.style.display = "none";
        }

        player.vast.skipButton = skipButton;
        player.el().appendChild(skipButton);

        player.on("timeupdate", player.vast.timeupdate);

        skipButton.onclick = function(e) {

          player.ads.endLinearAdMode();
          player.vast.tearDown();

          if(window.Event.prototype.stopPropagation !== undefined) {

            e.stopPropagation();

          } else {

            return false;

          }

        };

        player.vast.setupEvents();

        player.trigger('vast-preroll-ready');

        player.one('adended', player.vast.tearDown);

      },

      tearDown: function() {
        // remove preroll buttons
        player.vast.skipButton.parentNode.removeChild(player.vast.skipButton);
        player.vast.blocker.parentNode.removeChild(player.vast.blocker);

        // remove vast-specific events
        player.off('timeupdate', player.vast.timeupdate);
        player.off('ended', player.vast.tearDown);

        // end ad mode
        player.ads.endLinearAdMode();

        // show player controls for video
        if (player.vast.showControls) {
          player.controls(true);
        }

        player.trigger('vast-preroll-removed');


      },

      timeupdate: function(e) {

        player.loadingSpinner.el().style.display = "none";

        var timeLeft = Math.ceil(settings.skip - player.currentTime());

        if(timeLeft > 0) {

          player.vast.skipButton.innerHTML = "Skip in " + timeLeft + "...";

        } else {

          if((' ' + player.vast.skipButton.className + ' ').indexOf(' enabled ') === -1){
            player.vast.skipButton.className += " enabled";
            player.vast.skipButton.innerHTML = "Skip";
          }
        }
      },

    };

  },

  vastPlugin = function(options) {
    var player = this;
    var settings = extend({}, defaults, options || {});

    // check that we have the ads plugin
    if (player.ads === undefined) {
      window.console.error('vast video plugin requires videojs-contrib-ads, vast plugin not initialized');
      return null;
    }

    // set up vast plugin, then set up events here
    player.vast = new Vast(player, settings);

    player.on('vast-ready', function () {
      // vast is prepared with content, set up ads and trigger ready function
      player.trigger('adsready');
    });

    player.on('vast-preroll-ready', function () {
      // start playing preroll, note: this should happen this way no matter what, even if autoplay
      //  has been disabled since the preroll function shouldn't run until the user/autoplay has
      //  caused the main video to trigger this preroll function
      // @dev comment
      // AIRKIT.setVideoAdStats.init('views');
      player.play();
    });

    player.on('vast-preroll-removed', function () {
      // preroll done or removed, start playing the actual video
      //@dev comment: on ipad video must be started by user action.
      if( !videojs.browser.IS_IOS && !videojs.browser.IS_ANDROID ) {
        player.play();
      }
    });

    player.on('contentupdate', function(){
      // videojs-ads triggers this when src changes
      player.vast.getContent();
    });

    player.on('readyforpreroll', function() {
      // if we don't have a vast url, just bail out
      if (!settings.src) {
        player.trigger('adscanceled');
        return null;
      }
      // set up and start playing preroll
      player.vast.preroll();
    });

    // make an ads request immediately so we're ready when the viewer hits "play"
    if (player.currentSrc()) {
      player.vast.getContent(settings.url);
    }

    // return player to allow this plugin to be chained
    return player;
  };

  videojs.plugin('vast', vastPlugin);

}(window, videojs));

/*-0------------------------------------------------------*/


/**
 * Basic Ad support plugin for video.js.
 *
 * Common code to support ad integrations.
 */
(function(window, videojs, undefined) {

var

  VIDEO_EVENTS = videojs.getComponent('Html5').Events,

  /**
   * Pause the player so that ads can play, then play again when ads are done.
   * This makes sure the player is paused during ad loading.
   *
   * The timeout is necessary because pausing a video element while processing a `play`
   * event on iOS can cause the video element to continuously toggle between playing and
   * paused states.
   *
   * @param {object} player The video player
   */
  cancelContentPlay = function(player) {
    if (player.ads.cancelPlayTimeout) {
      // another cancellation is already in flight, so do nothing
      return;
    }

    // Avoid content flash on non-iPad iOS
    if (videojs.browser.IS_IOS && !videojs.browser.IS_IPAD) {

      var width = player.currentWidth ? player.currentWidth() : player.width();
      var height = player.currentHeight ? player.currentHeight() : player.height();

      // A placeholder black box will be shown in the document while the player is hidden.
      // var placeholder = document.createElement('div');
      //     placeholder.style.width = width + 'px';
      //     placeholder.style.height = height + 'px';
      //     placeholder.style.background = 'black';
      //     player.el_.parentNode.insertBefore(placeholder, player.el_);

      // Hide the player. While in full-screen video playback mode on iOS, this
      // makes the player show a black screen instead of content flash.
      // player.el_.style.display = 'none';

      // // Unhide the player and remove the placeholder once we're ready to move on.
      // player.one(['adplaying', 'adtimeout', 'adserror', 'adscanceled', 'adskip',
      //             'contentplayback'], function() {
      //   player.el_.style.display = 'block';
      //   placeholder.remove();
      // });
    }
    
    player.ads.cancelPlayTimeout = window.setTimeout(function() {
      // deregister the cancel timeout so subsequent cancels are scheduled
      player.ads.cancelPlayTimeout = null;

      // pause playback so ads can be handled.
      if (!player.paused()) {
        player.pause();
      }

      // add a contentplayback handler to resume playback when ads finish.
      player.one('contentplayback', function() {
        if (player.paused()) {
          player.play();
        }
      });
    }, 1);
  },

  /**
   * Remove the poster attribute from the video element tech, if present. When
   * reusing a video element for multiple videos, the poster image will briefly
   * reappear while the new source loads. Removing the attribute ahead of time
   * prevents the poster from showing up between videos.
   * @param {object} player The videojs player object
   */
  removeNativePoster = function(player) {
    var tech = player.$('.vjs-tech');
    if (tech) {
      tech.removeAttribute('poster');
    }
  },

  /**
   * Returns an object that captures the portions of player state relevant to
   * video playback. The result of this function can be passed to
   * restorePlayerSnapshot with a player to return the player to the state it
   * was in when this function was invoked.
   * @param {object} player The videojs player object
   */
  getPlayerSnapshot = function(player) {

    var currentTime;

    if (videojs.browser.IS_IOS && player.ads.isLive(player)) {
      // Record how far behind live we are
      if (player.seekable().length > 0) {
        currentTime = player.currentTime() - player.seekable().end(0);
      } else {
        currentTime = player.currentTime();
      }
    } else {
      currentTime = player.currentTime();
    }

    var
      tech = player.$('.vjs-tech'),
      tracks = player.remoteTextTracks ? player.remoteTextTracks() : [],
      track,
      i,
      suppressedTracks = [],
      snapshot = {
        ended: player.ended(),
        currentSrc: player.currentSrc(),
        src: player.src(),
        currentTime: currentTime,
        type: player.currentType()
      };

    if (tech) {
      snapshot.nativePoster = tech.poster;
      snapshot.style = tech.getAttribute('style');
    }

    i = tracks.length;
    while (i--) {
      track = tracks[i];
      suppressedTracks.push({
        track: track,
        mode: track.mode
      });
      track.mode = 'disabled';
    }
    snapshot.suppressedTracks = suppressedTracks;

    return snapshot;
  },

  /**
   * Attempts to modify the specified player so that its state is equivalent to
   * the state of the snapshot.
   * @param {object} snapshot - the player state to apply
   */
  restorePlayerSnapshot = function(player, snapshot) {
    if (player.ads.disableNextSnapshotRestore === true) {
        player.ads.disableNextSnapshotRestore = false;
        return;
    }
    var
      // the playback tech
      tech = player.$('.vjs-tech'),

      // the number of remaining attempts to restore the snapshot
      attempts = 20,

      suppressedTracks = snapshot.suppressedTracks,
      trackSnapshot,
      restoreTracks =  function() {
        var i = suppressedTracks.length;
        while (i--) {
          trackSnapshot = suppressedTracks[i];
          trackSnapshot.track.mode = trackSnapshot.mode;
        }
      },

      // finish restoring the playback state
      resume = function() {
        var currentTime;

        if (videojs.browser.IS_IOS && player.ads.isLive(player)) {
          if (snapshot.currentTime < 0) {
            // Playback was behind real time, so seek backwards to match
            if (player.seekable().length > 0) {
              currentTime = player.seekable().end(0) + snapshot.currentTime;
            } else {
              currentTime = player.currentTime();
            }
            player.currentTime(currentTime);
          }
        } else {
          player.currentTime(snapshot.ended ? player.duration() : snapshot.currentTime);
        }

        // Resume playback if this wasn't a postroll
        if (!snapshot.ended) {
          // player.play();
        }
      },

      // determine if the video element has loaded enough of the snapshot source
      // to be ready to apply the rest of the state
      tryToResume = function() {

        // tryToResume can either have been called through the `contentcanplay`
        // event or fired through setTimeout.
        // When tryToResume is called, we should make sure to clear out the other
        // way it could've been called by removing the listener and clearing out
        // the timeout.
        player.off('contentcanplay', tryToResume);

        if (player.ads.tryToResumeTimeout_) {
          player.clearTimeout(player.ads.tryToResumeTimeout_);
          player.ads.tryToResumeTimeout_ = null;
        }

        // Tech may have changed depending on the differences in sources of the
        // original video and that of the ad
        // tech = player.el().querySelector('.vjs-tech');
        tech = player.tech_;

        if (tech.readyState > 1) {
          // some browsers and media aren't "seekable".
          // readyState greater than 1 allows for seeking without exceptions
          //@dev commented
          // return resume();
        }

        if (tech.seekable === undefined) {
          // if the tech doesn't expose the seekable time ranges, try to
          // resume playback immediately
          //@dev commented
          return resume();
        }

        if (tech.seekable.length > 0) {
          // if some period of the video is seekable, resume playback
          //@dev commented
          // return resume();
        }

        // delay a bit and then check again unless we're out of attempts
        if (attempts--) {
          // @dev commented
          // window.setTimeout(tryToResume, 50);
        } else {
          (function() {
            try {
              resume();
            } catch(e) {
              videojs.log.warn('Failed to resume the content after an advertisement', e);
            }
          })();
        }
      };

    if (snapshot.nativePoster) {
      tech.poster = snapshot.nativePoster;
    }

    if ('style' in snapshot) {
      // overwrite all css style properties to restore state precisely
      tech.setAttribute('style', snapshot.style || '');
    }

    // Determine whether the player needs to be restored to its state
    // before ad playback began. With a custom ad display or burned-in
    // ads, the content player state hasn't been modified and so no
    // restoration is required

    if (player.ads.videoElementRecycled()) {
      // on ios7, fiddling with textTracks too early will cause safari to crash
      player.one('contentloadedmetadata', restoreTracks);

      // if the src changed for ad playback, reset it
      player.src({ src: snapshot.currentSrc, type: snapshot.type });
      // safari requires a call to `load` to pick up a changed source
      player.load();
      // and then resume from the snapshots time once the original src has loaded
      // in some browsers (firefox) `canplay` may not fire correctly.
      // Reace the `canplay` event with a timeout.
      //@dev commented
      // player.one('contentcanplay', tryToResume);
      player.ads.tryToResumeTimeout_ = player.setTimeout(tryToResume, 50);
    } else if (!player.ended() || !snapshot.ended) {
      // if we didn't change the src, just restore the tracks
      restoreTracks();
      // the src didn't change and this wasn't a postroll
      // just resume playback at the current time.
      player.play();
    }
  },

  // ---------------------------------------------------------------------------
  // Ad Framework
  // ---------------------------------------------------------------------------

  // default framework settings
  defaults = {
    // maximum amount of time in ms to wait to receive `adsready` from the ad
    // implementation after play has been requested. Ad implementations are
    // expected to load any dynamic libraries and make any requests to determine
    // ad policies for a video during this time.
    timeout: 1000,

    // maximum amount of time in ms to wait for the ad implementation to start
    // linear ad mode after `readyforpreroll` has fired. This is in addition to
    // the standard timeout.
    prerollTimeout: 100,

    // maximum amount of time in ms to wait for the ad implementation to start
    // linear ad mode after `contentended` has fired.
    postrollTimeout: 100,

    // when truthy, instructs the plugin to output additional information about
    // plugin state to the video.js log. On most devices, the video.js log is
    // the same as the developer console.
    debug: true,

    // set this to true when using ads that are part of the content video
    stitchedAds: false
  },

  adFramework = function(options) {
    var player = this,
        settings = videojs.mergeOptions(defaults, options),
        fsmHandler;

    // prefix all video element events during ad playback
    // if the video element emits ad-related events directly,
    // plugins that aren't ad-aware will break. prefixing allows
    // plugins that wish to handle ad events to do so while
    // avoiding the complexity for common usage
    (function() {
      var videoEvents = VIDEO_EVENTS.concat([
        'firstplay',
        'loadedalldata'
      ]);

      var returnTrue = function() { return true; };

      var triggerEvent = function(type, event) {
        // pretend we called stopImmediatePropagation because we want the native
        // element events to continue propagating
        event.isImmediatePropagationStopped = returnTrue;
        event.cancelBubble = true;
        event.isPropagationStopped = returnTrue;
        player.trigger({
          type: type + event.type,
          state: player.ads.state,
          originalEvent: event
        });
      };

      player.on(videoEvents, function redispatch(event) {

        if (player.ads.state === 'ad-playback') {

          if (player.ads.videoElementRecycled() || player.ads.stitchedAds()) {
            triggerEvent('ad', event);
          }
          if( videojs.browser.IS_IOS && !videojs.browser.IS_IPAD ) {

            if( player.seeking() ) {
           
            }

            if( player.seeking() ) {
              if (window.current_time < player.currentTime()) {
                player.currentTime(0);
              }               
            }

            setInterval(function() {
              if ( !player.paused() && !player.seeking() ) {
                window.current_time = player.currentTime();
              }
            }, 1000);

          }

        } else if (player.ads.state === 'content-playback' && event.type === 'ended') {

          triggerEvent('content', event);

        } else if (player.ads.state === 'content-resuming') {

          if (player.ads.snapshot) {
            // the video element was recycled for ad playback
            if (player.currentSrc() !== player.ads.snapshot.currentSrc) {

              if (event.type === 'loadstart') {
                return;
              }

              return triggerEvent('content', event);

            // we ended playing postrolls and the video itself
            // the content src is back in place
            } else if (player.ads.snapshot.ended) {

              if ((event.type === 'pause' ||
                  event.type === 'ended')) {
                // after loading a video, the natural state is to not be started
                // in this case, it actually has, so, we do it manually
                player.addClass('vjs-has-started');
                // let `pause` and `ended` events through, naturally
                return;
              }
              // prefix all other events in content-resuming with `content`
              return triggerEvent('content', event);
            }
          }

          if (event.type !== 'playing') {

            triggerEvent('content', event);

          }

        }

      });
    })();

    // We now auto-play when an ad gets loaded if we're playing ads in the same video element as the content.
    // The problem is that in IE11, we cannot play in addurationchange but in iOS8, we cannot play from adcanplay.
    // This will allow ad-integrations from needing to do this themselves.
    player.on(['addurationchange', 'adcanplay'], function() {
      if (player.currentSrc() === player.ads.snapshot.currentSrc) {
        return;
      }

      player.play();
    });

    player.on('nopreroll', function() {
      player.ads.nopreroll_ = true;
    });

    player.on('nopostroll', function() {
      player.ads.nopostroll_ = true;
    });

    // replace the ad initializer with the ad namespace
    player.ads = {
      state: 'content-set',
      disableNextSnapshotRestore: false,

      // Call this when an ad response has been received and there are
      // linear ads ready to be played.
      startLinearAdMode: function() {
        if (player.ads.state === 'preroll?' ||
            player.ads.state === 'content-playback' ||
            player.ads.state === 'postroll?') {
          
          player.trigger('adstart');
        }
      },

      // Call this when a linear ad pod has finished playing.
      endLinearAdMode: function() {
        if (player.ads.state === 'ad-playback') {
          player.trigger('adend');
          // In the case of an empty ad response, we want to make sure that
          // the vjs-ad-loading class is always removed. We could probably check for
          // duration on adPlayer for an empty ad but we remove it here just to make sure
          player.removeClass('vjs-ad-loading');
        }
      },

      // Call this when an ad response has been received but there are no
      // linear ads to be played (i.e. no ads available, or overlays).
      // This has no effect if we are already in a linear ad mode.  Always
      // use endLinearAdMode() to exit from linear ad-playback state.
      skipLinearAdMode: function() {
        if (player.ads.state !== 'ad-playback') {
          player.trigger('adskip');
        }
      },

      stitchedAds: function(arg) {
        if (arg !== undefined) {
          this._stitchedAds = !!arg;
        }
        return this._stitchedAds;
      },

      // Returns whether the video element has been modified since the
      // snapshot was taken.
      // We test both src and currentSrc because changing the src attribute to a URL that
      // AdBlocker is intercepting doesn't update currentSrc.
      videoElementRecycled: function() {
        var srcChanged;
        var currentSrcChanged;

        if (!this.snapshot) {
          return false;
        }

        srcChanged = player.src() !== this.snapshot.src;
        currentSrcChanged = player.currentSrc() !== this.snapshot.currentSrc;

        return srcChanged || currentSrcChanged;
      },

      // Returns a boolean indicating if given player is in live mode.
      // Can be replaced when this is fixed: https://github.com/videojs/video.js/issues/3262
      isLive: function(player) {
        if (player.duration() === Infinity) {
          return true;
        } else if (videojs.browser.IOS_VERSION === "8" && player.duration() === 0) {
          return true;
        }
        return false;
      },

      // Return true if content playback should mute and continue during ad breaks.
      // This is only done during live streams on platforms where it's supported.
      // This improves speed and accuracy when returning from an ad break.
      shouldPlayContentBehindAd: function(player) {
        return !videojs.browser.IS_IOS &&
               !videojs.browser.IS_ANDROID &&
               player.duration() === Infinity;
      }

    };

    player.ads.stitchedAds(settings.stitchedAds);

    fsmHandler = function(event) {
      // Ad Playback State Machine
      var fsm = {
        'content-set': {
          events: {
            'adscanceled': function() {
              this.state = 'content-playback';
            },
            'adsready': function() {
              this.state = 'ads-ready';
            },
            'play': function() {
              this.state = 'ads-ready?';
              cancelContentPlay(player);
              // remove the poster so it doesn't flash between videos
              removeNativePoster(player);
            },
            'adserror': function() {
              this.state = 'content-playback';
            },
            'adskip': function() {
              this.state = 'content-playback';
            }
          }
        },
        'ads-ready': {
          events: {
            'play': function() {
              this.state = 'preroll?';
              cancelContentPlay(player);
            },
            'adskip': function() {
              this.state = 'content-playback';
            },
            'adserror': function() {
              this.state = 'content-playback';
            }
          }
        },
        'preroll?': {
          enter: function() {
            if (player.ads.nopreroll_) {
              // This will start the ads manager in case there are later ads
              player.trigger('readyforpreroll');

              // If we don't wait a tick, entering content-playback will cancel
              // cancelPlayTimeout, causing the video to not pause for the ad
              window.setTimeout(function() {
                // Don't wait for a preroll
                player.trigger('nopreroll');
              }, 1);
            } else {
              // change class to show that we're waiting on ads
              player.addClass('vjs-ad-loading');
              // schedule an adtimeout event to fire if we waited too long
              player.ads.adTimeoutTimeout = window.setTimeout(function() {
                player.trigger('adtimeout');
              }, settings.prerollTimeout);
              // signal to ad plugin that it's their opportunity to play a preroll
              player.trigger('readyforpreroll');
            }
          },
          leave: function() {
            window.clearTimeout(player.ads.adTimeoutTimeout);
            player.removeClass('vjs-ad-loading');
          },
          events: {
            'play': function() {
              cancelContentPlay(player);
            },
            'adstart': function() {
              this.state = 'ad-playback';
            },
            'adskip': function() {
              this.state = 'content-playback';
            },
            'adtimeout': function() {
              this.state = 'content-playback';
            },
            'adserror': function() {
              this.state = 'content-playback';
            },
            'nopreroll': function() {
              this.state = 'content-playback';
            }
          }
        },
        'ads-ready?': {
          enter: function() {
            player.addClass('vjs-ad-loading');
            player.ads.adTimeoutTimeout = window.setTimeout(function() {
              player.trigger('adtimeout');
            }, settings.timeout);
          },
          leave: function() {
            window.clearTimeout(player.ads.adTimeoutTimeout);
            player.removeClass('vjs-ad-loading');
          },
          events: {
            'play': function() {
              cancelContentPlay(player);
            },
            'adscanceled': function() {
              this.state = 'content-playback';
            },
            'adsready': function() {
              this.state = 'preroll?';
            },
            'adskip': function() {
              this.state = 'content-playback';
            },
            'adtimeout': function() {
              this.state = 'content-playback';
            },
            'adserror': function() {
              this.state = 'content-playback';
            }
          }
        },
        'ad-playback': {
          enter: function() {
            // capture current player state snapshot (playing, currentTime, src)
            if (!player.ads.shouldPlayContentBehindAd(player)) {
              this.snapshot = getPlayerSnapshot(player);
            }

            // Mute the player behind the ad
            if (player.ads.shouldPlayContentBehindAd(player)) {
              this.preAdVolume_ = player.volume();
              player.volume(0);
            }

            // add css to the element to indicate and ad is playing.
            player.addClass('vjs-ad-playing');

            // remove the poster so it doesn't flash between ads
            removeNativePoster(player);

            // We no longer need to supress play events once an ad is playing.
            // Clear it if we were.
            if (player.ads.cancelPlayTimeout) {
              // If we don't wait a tick, we could cancel the pause for cancelContentPlay,
              // resulting in content playback behind the ad
              window.setTimeout(function() {
                window.clearTimeout(player.ads.cancelPlayTimeout);
                player.ads.cancelPlayTimeout = null;
              }, 1);
            }
          },
          leave: function() {
            player.removeClass('vjs-ad-playing');
            if (!player.ads.shouldPlayContentBehindAd(player)) {
              restorePlayerSnapshot(player, this.snapshot);
            }

            // Reset the volume to pre-ad levels
            if (player.ads.shouldPlayContentBehindAd(player)) {
              player.volume(this.preAdVolume_);
            }
            
          },
          events: {
            'adend': function() {
              this.state = 'content-resuming';
            },
            'adserror': function() {
              this.state = 'content-resuming';
              //trigger 'adend' to notify that we are exiting 'ad-playback'
              player.trigger('adend');
            }
          }
        },
        'content-resuming': {
          enter: function() {
            if (this.snapshot && this.snapshot.ended) {
              window.clearTimeout(player.ads._fireEndedTimeout);
              // in some cases, ads are played in a swf or another video element
              // so we do not get an ended event in this state automatically.
              // If we don't get an ended event we can use, we need to trigger
              // one ourselves or else we won't actually ever end the current video.
              player.ads._fireEndedTimeout = window.setTimeout(function() {
                player.trigger('ended');
              }, 300);
            }
          },
          leave: function() {
            window.clearTimeout(player.ads._fireEndedTimeout);
          },
          events: {
            'contentupdate': function() {
              this.state = 'content-set';
            },
            contentresumed: function() {
              this.state = 'content-playback';
            },
            'playing': function() {
              this.state = 'content-playback';
            },
            'ended': function() {
              this.state = 'content-playback';
            }
          }
        },
        'postroll?': {
          enter: function() {
            this.snapshot = getPlayerSnapshot(player);
            if (player.ads.nopostroll_) {
              window.setTimeout(function() {
                // content-resuming happens after the timeout for backward-compatibility
                // with plugins that relied on a postrollTimeout before nopostroll was
                // implemented
                player.ads.state = 'content-resuming';
                player.trigger('ended');
              }, 1);
            } else {
              player.addClass('vjs-ad-loading');

              player.ads.adTimeoutTimeout = window.setTimeout(function() {
                player.trigger('adtimeout');
              }, settings.postrollTimeout);
            }
          },
          leave: function() {
            window.clearTimeout(player.ads.adTimeoutTimeout);
            player.removeClass('vjs-ad-loading');
          },
          events: {
            'adstart': function() {
              this.state = 'ad-playback';
            },
            'adskip': function() {
              this.state = 'content-resuming';
              window.setTimeout(function() {
                player.trigger('ended');
              }, 1);
            },
            'adtimeout': function() {
              this.state = 'content-resuming';
              window.setTimeout(function() {
                player.trigger('ended');
              }, 1);
            },
            'adserror': function() {
              this.state = 'content-resuming';
              window.setTimeout(function() {
                player.trigger('ended');
              }, 1);
            },
            'contentupdate': function() {
              this.state = 'ads-ready?';
            }
          }
        },
        'content-playback': {
          enter: function() {
            // make sure that any cancelPlayTimeout is cleared
            if (player.ads.cancelPlayTimeout) {
              window.clearTimeout(player.ads.cancelPlayTimeout);
              player.ads.cancelPlayTimeout = null;
            }
            // this will cause content to start if a user initiated
            // 'play' event was canceled earlier.
            player.trigger({
              type: 'contentplayback',
              triggerevent: player.ads.triggerevent
            });
          },
          events: {
            // in the case of a timeout, adsready might come in late.
            'adsready': function() {
              player.trigger('readyforpreroll');
            },
            'adstart': function() {
              this.state = 'ad-playback';
            },
            'contentupdate': function() {
              if (player.paused()) {
                this.state = 'content-set';
              } else {
                this.state = 'ads-ready?';
              }
              // When a new source is loaded into the player, we should remove the snapshot
              // to avoid confusing player state with the new content's state
              // i.e When new content is set, the player should fire the ended event
              if (this.snapshot && this.snapshot.ended) {
                this.snapshot = null;
              }
            },
            'contentended': function() {
              if (player.ads.snapshot && player.ads.snapshot.ended) {
                // player has already been here. content has really ended. good-bye
                return;
              }
              this.state = 'postroll?';
            },
            'play': function() {
              if (player.currentSrc() !== player.ads.contentSrc) {
                cancelContentPlay(player);
              }
            }
          }
        }
      };

      (function(state) {
        var noop = function() {};

        // process the current event with a noop default handler
        ((fsm[state].events || {})[event.type] || noop).apply(player.ads);

        // check whether the state has changed
        if (state !== player.ads.state) {

          // record the event that caused the state transition
          player.ads.triggerevent = event.type;

          // execute leave/enter callbacks if present
          (fsm[state].leave || noop).apply(player.ads);
          (fsm[player.ads.state].enter || noop).apply(player.ads);

          // output debug logging
          if (settings.debug) {
            videojs.log('ads', player.ads.triggerevent + ' triggered: ' + state + ' -> ' + player.ads.state);
          }
        }

      })(player.ads.state);

    };

    // register for the events we're interested in
    player.on(VIDEO_EVENTS.concat([
      // events emitted by ad plugin
      'adtimeout',
      'contentupdate',
      'contentplaying',
      'contentended',
      'contentresumed',

      // events emitted by third party ad implementors
      'adsready',
      'adserror',
      'adscanceled',
      'adstart',  // startLinearAdMode()
      'adend',    // endLinearAdMode()
      'adskip',   // skipLinearAdMode()
      'nopreroll'
    ]), fsmHandler);

    // keep track of the current content source
    // if you want to change the src of the video without triggering
    // the ad workflow to restart, you can update this variable before
    // modifying the player's source
    player.ads.contentSrc = player.currentSrc();

    // implement 'contentupdate' event.
    (function(){
      var
        // check if a new src has been set, if so, trigger contentupdate
        checkSrc = function() {
          var src;
          if (player.ads.state !== 'ad-playback') {
            src = player.currentSrc();
            if (src !== player.ads.contentSrc) {
              player.trigger({
                type: 'contentupdate',
                oldValue: player.ads.contentSrc,
                newValue: src
              });
              player.ads.contentSrc = src;
            }
          }
        };
      // loadstart reliably indicates a new src has been set
      player.on('loadstart', checkSrc);
      // check immediately in case we missed the loadstart
      window.setTimeout(checkSrc, 1);
    })();

    // kick off the fsm
    if (!player.paused()) {
      // simulate a play event if we're autoplaying
      fsmHandler({type:'play'});
    }

  };

  // register the ad plugin framework
  videojs.plugin('ads', adFramework);

})(window, videojs);


/*
 * simpleoverlay
 * https://github.com/brightcove/videojs-simpleoverlay
 *
 * Copyright (c) 2013 Brightcove
 * Licensed under the Apache 2 license.
 */

(function(videojs) {

    /**
     * Copies properties from one or more objects onto an original.
     */
    extend = function(obj /*, arg1, arg2, ... */) {
      var arg, i, k;
      for (i = 1; i < arguments.length; i++) {
        arg = arguments[i];
        for (k in arg) {
          if (arg.hasOwnProperty(k)) {
            obj[k] = arg[k];
          }
        }
      }
      return obj;
    },

    // define some reasonable defaults
    defaults = {
      // don't show any overlays by default
    },

    // plugin initializer
    simpleOverlay = function(options) {
      var
        // save a reference to the player instance
        player = this,

        // merge options and defaults
        settings = extend({}, defaults, options || {}),
        
        i,
        overlay;

      // insert the overlays into the player but keep them hidden initially
      for (i in settings) {

        overlay = settings[i];

        // Create anchor.
        overlay.el = document.createElement('a');
        overlay.el.setAttribute('href', overlay.url );
        overlay.el.setAttribute('target', 'blank');
        overlay.el.setAttribute('rel', 'nofollow');
        overlay.el.setAttribute('data-key', overlay.key);

        // add classes
        overlay.el.className = 'tsz-overlay-ad ';

        overlay.el.className += i + ' vjs-hidden';     

        if( i === 'text' ) {

          //create text overlay.
          overlay.el.textContent += overlay.textContent;


        } else {
          //create img overlay
          var img = document.createElement('img');
              img.setAttribute('src', overlay.image );

          overlay.el.appendChild(img);

        }

        overlay.closer = document.createElement('span');
        overlay.closer.className = 'ad-closer icon-close';

        overlay.el.appendChild(overlay.closer);

        overlay.closer.onclick = function(evt){
          console.log(evt.target);
          evt.preventDefault();
          overlay.el.remove();
          return false;
        }   

        overlay.el.onclick = function(evt){
          console.log(evt.target);
          if ( evt.target.outerHTML == '<span class="ad-closer icon-close"></span>' ) return;
          AIRKIT.setVideoAdStats.init('clicks', overlay.key);
        }

        player.el().appendChild(overlay.el);

        
      }
      
      // show and hide the overlays for this time period
      player.on('timeupdate', function() {
        var
          currentTime = player.currentTime(),
          i,
          overlay;

        // iterate over all the defined overlays
        for (i in settings) {
          overlay = settings[i];
          if (overlay.start <= currentTime && overlay.end > currentTime) {
            
            // if the overlay isn't already showing, show it
            if (/vjs-hidden/.test(overlay.el.className)) {
              AIRKIT.setVideoAdStats.init('views', overlay.key);
              overlay.el.className = overlay.el.className.replace(/\s?vjs-hidden/, '');
            }


          // if the overlay isn't already hidden, hide it
          } else if (!(/vjs-hidden/).test(overlay.el.className)) {
            overlay.el.className += ' vjs-hidden';
          }
        }
      });
    };
  
  // register the plugin with video.js
  videojs.plugin('simpleOverlay', simpleOverlay);

}(window.videojs));