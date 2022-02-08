import '@fortawesome/fontawesome-pro/js/fontawesome'
import '@fortawesome/fontawesome-pro/js/regular'
import '@scripts/bootstrap'
import { initSelect } from '@scripts/select'
import { initSentry } from '@scripts/sentry'
import 'bootstrap'
import 'masonry-layout'

initSentry()
initSelect(document)
