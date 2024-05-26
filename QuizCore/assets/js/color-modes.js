(() => {
  'use strict'

  const getStoredTheme = () => localStorage.getItem('theme')
  const setStoredTheme = theme => localStorage.setItem('theme', theme)

  const getPreferredTheme = () => {
    const storedTheme = getStoredTheme();
    if (storedTheme && storedTheme !== 'auto') {
      return storedTheme;
    }
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    return prefersDark ? 'dark' : 'light';
  }


  function switchTheme(themeId) {
    // Disable all themes
    document.querySelectorAll('link[id^="theme-"]').forEach(link => link.disabled = true);
    // Enable the selected theme
    var element = document.getElementById(themeId);
    if (element !== null) {
      element.disabled = false;
    }
  }

  const setButtonThemeWithID = (theme, elementId) => {
    const element = document.getElementById(elementId);

    document.documentElement.setAttribute('data-bs-theme', theme);
    if (element) {
      if (theme === 'dark') {
        element.classList.add('btn-bd-red');
      } else {
        element.classList.remove('btn-bd-red');
      }
    }
  }

  const setButtonTheme = theme => {
    setButtonThemeWithID(theme, 'signUpBtn')
  }

  setButtonTheme(getPreferredTheme())

  const showActiveTheme = (theme, focus = false) => {
    const themeSwitcher = document.querySelector('#bd-theme')

    if (!themeSwitcher) {
      return
    }

    const themeSwitcherText = document.querySelector('#bd-theme-text')
    const activeThemeIcon = document.querySelector('.theme-icon-active use')
    const btnToActive = document.querySelector(`[data-bs-theme-value="${theme}"]`)
    const svgOfActiveBtn = btnToActive.querySelector('svg use').getAttribute('href')

    document.querySelectorAll('[data-bs-theme-value]').forEach(element => {
      element.classList.remove('active')
      element.setAttribute('aria-pressed', 'false')
    })

    btnToActive.classList.add('active')
    btnToActive.setAttribute('aria-pressed', 'true')
    activeThemeIcon.setAttribute('href', svgOfActiveBtn)
    const themeSwitcherLabel = `${themeSwitcherText.textContent} (${btnToActive.dataset.bsThemeValue})`
    themeSwitcher.setAttribute('aria-label', themeSwitcherLabel)

    if (focus) {
      themeSwitcher.focus()
    }
  }

  const toggleTheme = theme => {
    setStoredTheme(theme);
    setButtonTheme(getPreferredTheme());
    showActiveTheme(theme, true);


    if (theme == "auto") {
      theme = getPreferredTheme();
    }
    if (theme == "dark") {
      switchTheme("theme-monokai");
    } else {
      switchTheme("theme-default");
    }
  }

  window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
    const theme = getStoredTheme();
    if (theme === 'auto') {
      toggleTheme('auto');
    } else {
      toggleTheme(theme);
    }
  })

  window.addEventListener('DOMContentLoaded', () => {
    setButtonTheme(getPreferredTheme());

    const storedTheme = getStoredTheme();
    if (storedTheme) {
      showActiveTheme(storedTheme);

      let theme = storedTheme;
      if (theme == "auto") {
        theme = getPreferredTheme();
      }
      if (theme == "dark") {
        switchTheme("theme-monokai");
      } else {
        switchTheme("theme-default");
      }
    }

    document.querySelectorAll('[data-bs-theme-value]')
      .forEach(toggle => {
        toggle.addEventListener('click', () => {
          const theme = toggle.getAttribute('data-bs-theme-value')
          if (theme === 'auto') {
            toggleTheme('auto');
          } else {
            toggleTheme(theme);
          }
        })
      })
  })


  // Set a default theme on page load
  switchTheme("theme-default");
})()
