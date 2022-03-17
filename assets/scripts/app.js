import '@fortawesome/fontawesome-pro/js/fontawesome'
import '@fortawesome/fontawesome-pro/js/regular'
import '@scripts/bootstrap'
import { initSelect } from '@scripts/select'
import { initSentry } from '@scripts/sentry'
import { initTooltip } from '@scripts/tooltip'
import 'bootstrap'
import 'masonry-layout'

initSentry()
initSelect(document)
initTooltip(document)
