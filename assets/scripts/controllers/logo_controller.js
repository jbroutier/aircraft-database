import { Controller } from '@hotwired/stimulus'
import Axios from 'axios'

export default class extends Controller {
  remove (event) {
    const { target, url } = event.params

    Axios
      .delete(url)
      .then(() => {
        const item = document.querySelector(target)
        item.remove()
        event.target.remove()
      })
  }
}
