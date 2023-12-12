// Initialize deferredPrompt for use later to show browser install prompt.
let deferredPrompt;

window.addEventListener('beforeinstallprompt', (e) => {
  e.preventDefault();
  if (getCookie('hideInstallPromotion') !== '1') {
    deferredPrompt = e;
    showInstallPromotion();
  }
});

function showInstallPromotion() {
  document.querySelector('.pwa_installation_banner')?.classList.add('visible');
}

function hideInstallPromotion() {
  document.querySelector('.pwa_installation_banner')?.classList.remove('visible');
}

function hideInstallPromotionFor90days() {
  hideInstallPromotion();
  setCookie('hideInstallPromotion', '1', 90);
}

function setCookie(name,value,days) {
  var expires = "";
  if (days) {
      var date = new Date();
      date.setTime(date.getTime() + (days*24*60*60*1000));
      expires = "; expires=" + date.toUTCString();
  }
  document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}

function getCookie(name) {
  var nameEQ = name + "=";
  var ca = document.cookie.split(';');
  for(var i=0;i < ca.length;i++) {
      var c = ca[i];
      while (c.charAt(0)==' ') c = c.substring(1,c.length);
      if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
  }
  return null;
}

addEventListener("DOMContentLoaded", (event) => {
  buttonInstall = document.querySelector('.pwa_installation_banner button.install');
  buttonInstall?.addEventListener('click', async () => {
    hideInstallPromotion();
    deferredPrompt?.prompt();
    const { outcome } = await deferredPrompt.userChoice;
    // Optionally, send analytics event with outcome of user choice
    console.log(`User response to the install prompt: ${outcome}`);
    // We've used the prompt, and can't use it again, throw it away
    deferredPrompt = null;
  });
  
  buttonCancel = document.querySelector('.pwa_installation_banner button.cancel');
  buttonCancel?.addEventListener('click', hideInstallPromotionFor90days);
});


window.addEventListener('appinstalled', () => {
  hideInstallPromotion();
  deferredPrompt = null;
});
