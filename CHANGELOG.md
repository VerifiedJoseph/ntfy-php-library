# Changelog

All notable changes to this project are documented in this file.

## [3.1.3](https://github.com/VerifiedJoseph/ntfy-php-library/releases/tag/v3.1.3) - 2022-05-29

* Updated supported `binwiederhier/ntfy` version from 1.23.0 to 1.24.0 ([`3321712`](https://github.com/VerifiedJoseph/ntfy-php-library/commit/3321712b57b919287bc20a9cb029ff8c0a572bde))

## [3.1.2](https://github.com/VerifiedJoseph/ntfy-php-library/releases/tag/v3.1.2) - 2022-05-26

* Updated dependency `guzzlehttp/guzzle` from 7.4.2 to 7.4.3. ([#62](https://github.com/VerifiedJoseph/ntfy-php-library/pull/62), [`6ba07b9`](https://github.com/VerifiedJoseph/ntfy-php-library/commit/6ba07b94b43f4072b98e74fa22f85b0ab778676c))

## [3.1.1](https://github.com/VerifiedJoseph/ntfy-php-library/releases/tag/v3.1.1) - 2022-05-21

* Updated supported `binwiederhier/ntfy` version from 1.22.0 to 1.23.0 ([`33029cf`](https://github.com/VerifiedJoseph/ntfy-php-library/commit/33029cff024d4ef5dd6d02a1b4a531f1ca811baa))

## [3.1.0](https://github.com/VerifiedJoseph/ntfy-php-library/releases/tag/v3.1.0) - 2022-04-09

* Added `name` parameter to `Message` class method `attachURL()`. ([`7b4f641`](https://github.com/VerifiedJoseph/ntfy-php-library/commit/7b4f641f4b6850a137f367cff74793b1b234aad9))
* Updated `Message` class method `schedule()` to require delay parameter value be a string. ([`6e05139`](https://github.com/VerifiedJoseph/ntfy-php-library/commit/6e05139dee90534c574ecd90ec879c5daeb3113c))

## [3.0.0](https://github.com/VerifiedJoseph/ntfy-php-library/releases/tag/v3.0.0) - 2022-04-08

* Reworked library to publish messages as JSON. ([#53](https://github.com/VerifiedJoseph/ntfy-php-library/pull/53). [`fcd7662`](https://github.com/VerifiedJoseph/ntfy-php-library/commit/fcd76626135e1b3632a61c2e0cddbd6e69f9c0b4))
* Added support for action buttons. ([#54](https://github.com/VerifiedJoseph/ntfy-php-library/pull/54). [`00f9072`](https://github.com/VerifiedJoseph/ntfy-php-library/commit/00f90720e94fcbe697e8ed28e89bf8e177ec6822))
* Updated supported `binwiederhier/ntfy` version from 1.18.0 to 1.22.0.
* Updated dependency `guzzlehttp/guzzle` from 7.4.1 to 7.4.2 ([#38](https://github.com/VerifiedJoseph/ntfy-php-library/pull/38). [`8c7d2c6`](https://github.com/VerifiedJoseph/ntfy-php-library/commit/8c7d2c6a2cc771f8b148472e08b830b38a8c4f3b))

## [2.1.1](https://github.com/VerifiedJoseph/ntfy-php-library/releases/tag/v2.1.1) - 2022-03-17

* Updated supported ntfy version from 1.14.0 to 1.18.0. ([`75e3354`](https://github.com/VerifiedJoseph/ntfy-php-library/commit/75e33544e2ecea4fe45628d5b10db9c762eaf44d))

## [2.1.0](https://github.com/VerifiedJoseph/ntfy-php-library/releases/tag/v2.1.0) - 2022-02-08

* Updated supported binwiederhier/ntfy version from 1.13.0 to 1.14.0.
* Added support for basic access authentication. ([#25](https://github.com/VerifiedJoseph/ntfy-php-library/pull/25), [`587fb60`](https://github.com/VerifiedJoseph/ntfy-php-library/commit/587fb60bdfcb497ff50d3fcf1ce420701cea2ecd))

## [2.0.0](https://github.com/VerifiedJoseph/ntfy-php-library/releases/tag/v2.0.0) - 2022-02-01

Version 2 is **not** backwards compatible. See the updated [documentation](https://github.com/VerifiedJoseph/ntfy-php-library/tree/main/docs).

* Major library rewrite. ([#20](https://github.com/VerifiedJoseph/ntfy-php-library/pull/20))

## [1.2.0](https://github.com/VerifiedJoseph/ntfy-php-library/releases/tag/v1.1.0) - 2021-12-14

* Added support for disabling message caching. ([`b5bfa94`](https://github.com/VerifiedJoseph/ntfy-php-library/commit/b5bfa94578b6123e32fbdf214e3e4410d93645e6))
* Added support for delaying messages. ([`8974a7b`](https://github.com/VerifiedJoseph/ntfy-php-library/commit/8974a7b4764a8c85ba4609c2e92b8b69392d99c8))

## [1.1.0](https://github.com/VerifiedJoseph/ntfy-php-library/releases/tag/v1.1.0) - 2021-12-09

* Added message priority constants. ([#6](https://github.com/VerifiedJoseph/ntfy-php-library/pull/6))

## [1.0.0](https://github.com/VerifiedJoseph/ntfy-php-library/releases/tag/v1.0.0) - 2021-12-06
Initial release
