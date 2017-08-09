delectus-search
---------------

Delectus search module is installed by clients on their website and hooks into their SilverStripe install to interface 
with delectus-backend to provide for searching for data previously indexed by the delectus-index module

It needs to be configured with the ClientToken and ClientSalt and Site Identifier settings from delectus-frontend for their Client account,
this can be done either in a yaml config file:

```
DelectusSearchModule:
	client_token: '<token from client account>'
	client_salt: '<salt from client account>'
	site_identifier: '<site identifier for the website>'
```

Or can be set in the 'Delectus' tab of the Site Settings in the CMS. Settings
made in the CMS will override those in yaml config.

 

 
