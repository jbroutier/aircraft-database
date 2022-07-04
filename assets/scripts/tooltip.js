import { Tooltip } from 'bootstrap'

export default function initTooltip (parent = document) {
  parent.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(element => {
    const tooltip = new Tooltip(element)
    tooltip.enable()
  })
}
