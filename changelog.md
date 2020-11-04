# Changelog

## SwiperSlider 2.0
- update: swiper 6.3.5
- add: Parallax Komponenten ist eingebaut
- add: dir="rtl" - das Layout kann von rechts nach links angeordnet werden
- add: Hash Navigation
- add: History API
- future: Support für die Unite Response Tile Gallery
- future: Videos im Slider?

#### [Swiper 6.3.5](https://github.com/nolimits4web/swiper/compare/v6.3.4...v6.3.5) - Released on October 30th, 2020

- Build
  - Fixed builds on Windows
- Core
  - Fixed no swiping class in shadow component (#3868)
  - Typecheck for `slideTo`'s `index` parameter

#### [Swiper 6.3.4](https://github.com/nolimits4web/swiper/compare/v6.3.3...v6.3.4) - Released on October 20th, 2020

- Vue
  - Fixed issue with `Maximum recursive updates`

#### [Swiper 6.3.3](https://github.com/nolimits4web/swiper/compare/v6.3.2...v6.3.3) - Released on October 9th, 2020

- Core
  - Fixed issue with wrong slides calculation when slides have inner scrollbars
- Autoplay
  - Now it will continue autoplay if it reaches the end and new slides will be added later
- React
  - Fixed issue when slide render function data was set only after interaction
- Minor fixes

#### [Swiper 6.3.2](https://github.com/nolimits4web/swiper/compare/v6.3.1...v6.3.2) - Released on September 28th, 2020

- Svelte
  - Fixed issue with throwing error when using breakpoints

#### [Swiper 6.3.1](https://github.com/nolimits4web/swiper/compare/v6.3.0...v6.3.1) - Released on September 25th, 2020

- Core

  - A11y
    - Init module after all other modules initialized
