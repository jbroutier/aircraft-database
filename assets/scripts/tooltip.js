import { Tooltip } from 'bootstrap'

document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(element => {
  const tooltip = new Tooltip(element)
  tooltip.enable()
})
