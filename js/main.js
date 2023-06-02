window.onload = function() {
  const languages = [
    'WELCOME, USER',       
    'BIENVENIDO, USUARIO',  
    'BEM-VINDO, USUÁRIO',     
    '환영합니다, 사용자',    
    'ようこそ、ユーザーさん' 
  ];
  const animatedTextContainer = document.querySelector('.animated-text');
  const binary = '01';
  let currentLangIndex = 0;

  if(!animatedTextContainer) {
    console.error("No element with class .animated-text found");
    return;
  }

  for (let i = 0; i < languages[0].length; i++) {
    const span = document.createElement('span');
    span.textContent = ' ';
    animatedTextContainer.appendChild(span);
  }

  function animateLetter(index, lang) {
    if (index < languages[lang].length) {
      const span = animatedTextContainer.children[index];
      let counter = 0;
      let intervalId = setInterval(function() {
        if(span){
            span.textContent = binary[counter % 2];
            counter++;
            if (counter > 5) {
              clearInterval(intervalId);
              if(span){
                  span.textContent = languages[lang][index];
              }
              animateLetter(index + 1, lang);
            }
        }
      }, 10);
    }
  }

  function switchLanguage() {
    animatedTextContainer.innerHTML = '';
    const nextLangIndex = (currentLangIndex + 1) % languages.length;
    for (let i = 0; i < languages[nextLangIndex].length; i++) {
      const span = document.createElement('span');
      span.textContent = ' ';
      animatedTextContainer.appendChild(span);
    }
    animateLetter(0, nextLangIndex);
    currentLangIndex = nextLangIndex;
  }

  animateLetter(0, currentLangIndex);

  setInterval(switchLanguage, 2000);
}

// Preloader
window.addEventListener('load', function() {
  var img = new Image();
  img.onload = function() {
    console.log('Image loaded successfully');
    simulateProgress();
  };
  img.onerror = function() {
    console.log('Error loading image');
  };
  img.src = document.getElementById('loading-logo').src;
});

function simulateProgress() {
  const preloaderTop = document.getElementById('preloader-top');
  const preloaderBottom = document.getElementById('preloader-bottom');
  const loadingLogo = document.getElementById('loading-logo');

  let interval = setInterval(frame, 80);
  let width = 0;

  function frame() {
      if (width >= 100) {
          clearInterval(interval);
          // Add fading and sliding animations
          preloaderTop.style.animation = "preloaderFadeOut 0.5s, preloaderSlideOut 0.5s 0.5s";
          preloaderBottom.style.animation = "preloaderFadeOut 0.5s, preloaderSlideOut 0.5s 0.5s";
          loadingLogo.style.animation = "preloaderFadeOut 0.5s";

          setTimeout(function() {
              preloaderTop.style.display = "none";
              preloaderBottom.style.display = "none";
              loadingLogo.style.display = "none";
          }, 1000);
      } else {
          width++;
      }
  }
}

