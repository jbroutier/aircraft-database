import { startStimulusApp } from '@symfony/stimulus-bridge'

export function initStimulus () {
  startStimulusApp(
    require.context('@symfony/stimulus-bridge/lazy-controller-loader!./controllers', true, /\.js$/)
  )
}
