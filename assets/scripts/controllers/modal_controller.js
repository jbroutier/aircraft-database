import { Controller } from '@hotwired/stimulus'
import { initSelect } from '@scripts/select'
import Axios from 'axios'
import { Modal } from 'bootstrap'

export default class extends Controller {
  show (event) {
    const { url } = event.params

    Axios
      .get(url)
      .then(response => {
        const parser = new DOMParser()
        const fragment = parser.parseFromString(response.data, 'text/html')
        initSelect(fragment)
        const modal = fragment.querySelector('.modal')
        modal.addEventListener('hidden.bs.modal', () => {
          modal.remove()
        })
        const content = document.querySelector('main')
        content.appendChild(modal)
        new Modal(modal).show()
      })
  }

  submit (event) {
    const { url } = event.params
    const data = new FormData(event.target.closest('form'))

    Axios
      .post(url, data)
      .then(response => {
        const parser = new DOMParser()
        const fragment = parser.parseFromString(response.data, 'text/html')
        initSelect(fragment)
        if (fragment.querySelector('.modal-content')) {
          const modalContent = event.target.closest('.modal-content')
          modalContent.replaceWith(fragment.querySelector('.modal-content'))
        } else {
          const body = event.target.closest('body')
          body.replaceWith(fragment.querySelector('body'))
        }
      })
  }

  update (event) {
    const { url } = event.params

    Axios
      .get(url)
      .then(response => {
        const parser = new DOMParser()
        const fragment = parser.parseFromString(response.data, 'text/html')
        initSelect(fragment)
        fragment.querySelector('.modal-content')
        const modalContent = event.target.closest('.modal-content')
        modalContent.replaceWith(fragment.querySelector('.modal-content'))
      })
  }
}
