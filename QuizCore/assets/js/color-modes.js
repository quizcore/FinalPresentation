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
    setButtonTheme(theme);
    showActiveTheme(theme, true);
  }

  window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
    const storedTheme = getStoredTheme()
    if (storedTheme !== 'light' && storedTheme !== 'dark' && storedTheme !== 'auto') {
      setButtonTheme(getPreferredTheme())
    }
  })

  window.addEventListener('DOMContentLoaded', () => {
    setButtonTheme(getPreferredTheme())

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
})()
