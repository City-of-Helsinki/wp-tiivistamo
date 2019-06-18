# How to set up Oodi prod

Memos and notes about what needs to be done once we launch Oodi code update.


## General

- Events (LinkedEvents) / Spaces (Respa) are not actually in API yet (as of 31.10.), so those won't be in use at launch.
- This project comes with two custom plugins (Respa WP Plugin & LinkedEvents WP Plugin) that are used to interact with Respa & LinkedEvents.
- The plugins currently (31.10.) do **NOT** have the correct query parameters. This is because Oodi does not actually have any content yet in the respective APIs.
- The above means that when these are actually in the APIs, one needs to update the plugin files (`class-hyperin.php` in both plugins) and change the `tprek:xxxx` or equivalent ID to the correct one(s).
- Oodi sets up separate "opening events" under new `Featured Activities` content type & block (already in master, already trained to use).
- Opening Times should be fetched from an API, but there is currently (as of 31.10.) no API that returns this data. The `summary` block can be used on the front page to present opening times on the front page manually. Website Options has a field required for displaying daily info on header (link to a page for all), but the actual fetching of data from API -functionality does not exist yet because of no API spec for fetching such data.



## Primary steps

These should be taken to launch the actual code update for the immediate now.

- Coordinate launch time schedule with Oodi / let them know when we deploy (nothing specific agreed, just a good idea in general)
- Merge `feature/phase-2` branch to master
- Pull db from prod and test everything (existing pages) in dev to work as expected
- Deploy to staging
- Test on staging
- On PRODUCTION, go through main pages and delete unnecessary blocks (old site uses `Breadcrumbs` blocks on pages, but we dont want them anymore -- in new codebase the breadcrumbs block is deleted)
- On PRODUCTION, replace the front page `Hero` block with `Subpage Hero` block (dumb, I know). In new codebase the Hero block is deleted.
- Deploy _code_ (and not db) to production
- Test production & infom client about code updates


## Secondary steps

These steps are for the future of the website update when we start using Respa/LinkedEvents integrations. Can be done now already though.

- Create `LinkedEvents` -named page for each language (used by LinkedEvents integration) using the `Single event` template
- Activate LinkedEvents WP Plugin & Respa WP Plugin on prod (enables `wp-json/linkedevents/v1/updateevents`, `wp-json/linkedevents/v1/events` / `wp-json/respa/v1/updatespaces`, `wp-json/respa/v1/spaces` and the plugin activation should also set up WP cron to run the updates through cron.php file in plugin files). These endpoints are used by LinkedEvents / Respa blocks.
- Go through WPML string translation (`swiss` domain) and translate ~10 new strings at the top of the view (`day`, `event` etc.). Client has also been trained to do this.


## Tertiary steps

These need to be taken when the LinkedEvents / Respa APIs actually have data for Oodi.

- Change the query params in LinkedEvents / Respa plugins to correctly fetch content from the right source
- (see `general` of this file for more info)
