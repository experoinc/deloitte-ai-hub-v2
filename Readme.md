# Deloitte AI-Hub

## Developing

From themes/deloitte-ai:

```bash
npm install
npm run watch
```


## Building and deploying for production

First we need to build ai-hub-blocks plugin.

From wp-content:
```bash
cd plugins/ai-hub-blocks
npm run build
```

Then build the theme:
```bash
cd ../../themes/deloitte-ai
npm run prod
```


The final step is to export the wp installation with All-inOne WP Migration plugin.
This steps assume you already have a wordpress installation on a web server.

With wordpress installed locally login as admin and from admin console go to All-In-one Wp Migration menu item, select Export To, select File, wait for archive file to be created and press Download button
Login as admin to the target wordpress site, you need to have  All-In-one Wp Migration plugin installed then from All-In-one Wp Migration menu select  Import and  select the archive file


