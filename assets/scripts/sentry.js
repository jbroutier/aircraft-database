import { init, setTags, setUser } from '@sentry/browser'
import { BrowserTracing } from '@sentry/tracing'

export function initSentry () {
  const html = document.querySelector('html')

  init({
    debug: html.dataset.debug,
    dsn: process.env.SENTRY_DSN,
    environment: html.dataset.environment,
    ignoreErrors: [],
    integrations: [
      new BrowserTracing({
        tracingOrigins: [
          'https://aircraft-database.com',
          'https://aircraft-database.local'
        ]
      })
    ],
    release: html.dataset.release,
    tracesSampleRate: 1.0
  })

  setTags({
    locale: html.dataset.locale
  })

  setUser({
    id: html.dataset.userId,
    ip_address: html.dataset.userIpAddress,
    username: html.dataset.userName
  })
}
