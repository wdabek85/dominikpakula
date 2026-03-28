/**
 * Lite YouTube Embed
 *
 * Uses YouTube IFrame API to control play/pause states.
 * - Click play → placeholder fades out, video plays
 * - Pause video → placeholder fades back in
 * - Click play again → video resumes from paused position
 *
 * Elements: [data-youtube-id] inside a parent <section>
 */
export default function liteYoutube() {
  const triggers = document.querySelectorAll('[data-youtube-id]');
  if (!triggers.length) return;

  // Load YouTube IFrame API
  const tag = document.createElement('script');
  tag.src = 'https://www.youtube.com/iframe_api';
  document.head.appendChild(tag);

  window.onYouTubeIframeAPIReady = () => {
    triggers.forEach((trigger) => {
      const youtubeId = trigger.dataset.youtubeId;
      const section = trigger.closest('section');
      if (!youtubeId || !section) return;

      // Wrapper that stays styled, player div inside it
      const wrapper = document.createElement('div');
      wrapper.style.cssText = 'position:absolute;inset:0;width:100%;height:100%;z-index:20;opacity:0;transition:opacity 0.6s ease;pointer-events:none;';

      const playerDiv = document.createElement('div');
      playerDiv.id = `yt-player-${youtubeId}`;
      playerDiv.style.cssText = 'width:100%;height:100%;';

      wrapper.appendChild(playerDiv);
      section.appendChild(wrapper);

      // Elements to fade
      const bgImage = section.querySelector('img[aria-hidden]');
      const overlay = section.querySelector('.bg-black\\/30');
      const content = section.querySelector('.relative.flex');

      let player = null;
      let isInitialized = false;

      const showPlaceholder = () => {
        wrapper.style.opacity = '0';
        wrapper.style.pointerEvents = 'none';
        [bgImage, overlay, content].forEach((el) => {
          if (el) {
            el.style.transition = 'opacity 0.6s ease';
            el.style.opacity = '1';
          }
        });
        trigger.style.display = '';
      };

      const hidePlaceholder = () => {
        wrapper.style.opacity = '1';
        wrapper.style.pointerEvents = 'auto';
        [bgImage, overlay, content].forEach((el) => {
          if (el) {
            el.style.transition = 'opacity 0.6s ease';
            el.style.opacity = '0';
          }
        });
        trigger.style.display = 'none';
      };

      trigger.addEventListener('click', () => {
        if (!isInitialized) {
          player = new YT.Player(playerDiv.id, {
            videoId: youtubeId,
            width: '100%',
            height: '100%',
            playerVars: {
              autoplay: 1,
              rel: 0,
              modestbranding: 1,
              origin: window.location.origin,
            },
            events: {
              onReady: () => {
                hidePlaceholder();
              },
              onStateChange: (event) => {
                if (event.data === YT.PlayerState.PAUSED) {
                  showPlaceholder();
                } else if (event.data === YT.PlayerState.PLAYING) {
                  hidePlaceholder();
                } else if (event.data === YT.PlayerState.ENDED) {
                  showPlaceholder();
                  isInitialized = false;
                }
              },
            },
          });
          isInitialized = true;
        } else if (player && player.playVideo) {
          player.playVideo();
        }
      });
    });
  };
}
