import { Controller } from '@hotwired/stimulus'
import slugify from 'slugify'

export default class extends Controller {
  generate (event) {
    const { target } = event.params
    const slug = document.querySelector(target)
    slug.value = slugify(event.target.value, { lower: true })
  }
}
