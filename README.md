<p align="center">
    <img src="logo.svg" width="250" height="250" alt="">
</p>

[![Node](https://github.com/jbroutier/aircraft-database/actions/workflows/node.yml/badge.svg)](https://github.com/jbroutier/aircraft-database/actions/workflows/node.yml)
[![PHP](https://github.com/jbroutier/aircraft-database/actions/workflows/php.yml/badge.svg)](https://github.com/jbroutier/aircraft-database/actions/workflows/php.yml)
[![Codecov](https://codecov.io/gh/jbroutier/aircraft-database/branch/main/graph/badge.svg?token=1NSIYQDVJQ)](https://codecov.io/gh/jbroutier/aircraft-database)
[![Website](https://img.shields.io/website?url=https%3A%2F%2Faircraft-database.com&logo=data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABYklEQVQ4y+2RsYpTURRF1z1zfXnJqDEwMQRNLQQLu7FNMc1AuuQR/BIrSRr/QjIG0iTFg1T+gmjjIIygjYXNCKZIgq94924LHckI/sHs7mw463D2hhu5/UGSm8/nd5Ik8VmW/bjyx+Oxtdvtg0aj4YfDYbFcLq3ZbLper1e6f4l5nt8LITwaDAZvARaLxcF6vTbgVrVavZ0kyYmZPZO0NrP5NcBsNjus1WodSS+AN8B3SZ8AYoypmVUkdSR9GY1GFwBekuV5flSW5amZfYwxHjnnzoCBpA5wX9JL7/05oLIsv7Varc9XR71zLgKXwBnAdDpN6/X63RBCFXgu6bWZnUp6Kum99/7DZrNJgBLA7wfV7XaPY4zHIYSfklqS3pnZRtID4CFwGGNc9fv94r8tTCYT9wcYAVarVW232z3x3iPpMfAqy7Lw94VrnTonQPteURSqVCrabrfnaZp+3V++0W/9Ag9Ro4Msd4TwAAAAAElFTkSuQmCC)](https://aircraft-database.com)
[![PHP version](https://img.shields.io/badge/php-8.1-787cb5?logo=php)](https://github.com/jbroutier/aircraft-database)
[![Symfony version](https://img.shields.io/badge/symfony-6.1-000000?logo=symfony)](https://github.com/jbroutier/aircraft-database)

# Aircraft database

Global database of aircraft and engine models.

## Project's goal

The goal is to gather as much technical data as possible on aircraft around the world, and to make them accessible in a
synthetic, readable way (Did someone say "tables"?).

Why? The data concerned are often publicly available but are scattered in several documents (FAA and/or EASA Type
Certificate Data Sheets, Airport Planning Manuals, manufacturer datasheets, commercial leaflets) which are not always
very easy to interpret, nor pleasant to read.

## Data sources

The data comes from:

- FAA and/or EASA Type Certificate Data Sheets;
- Aircraft Operating Manuals;
- Airport Planning Manuals;
- Manufacturer datasheets;
- Commercial leaflets;
- Museums, Books.

## License

The source code is published under the terms of the [MIT license](https://spdx.org/licenses/MIT.html). However, there is
not much to see. It’s more or less a basic Symfony application with CRUD and stuff like that.

The data is published under the terms of the [ODC-By 1.0](https://opendatacommons.org/licenses/by/1-0/) license.
