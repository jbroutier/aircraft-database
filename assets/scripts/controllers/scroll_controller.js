import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
  top () {
    window.scrollTo({ top: 0, behavior: 'smooth' })
  }
}
