import { Controller } from '@hotwired/stimulus'
import { initSelect } from '@scripts/select'

export default class extends Controller {
  add (event) {
    const { target } = event.params
    const collection = document.querySelector(target)
    const prototype = collection.getAttribute('data-prototype')
    let counter = collection.getAttribute('data-counter') || collection.children.length
    const parser = new DOMParser()
    const fragment = parser.parseFromString(prototype.replace(/__name__/g, counter), 'text/html')
    initSelect(fragment)
    counter++
    collection.setAttribute('data-counter', counter)
    collection.firstElementChild.insertAdjacentElement('afterend', fragment.querySelector('[data-collection-item]'))
  }

  remove (event) {
    const { target } = event.params
    const item = document.querySelector(target)
    item.remove()
  }
}
