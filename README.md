# bpn_whitelist
TYPO3 whitelist for IPs to secure certain API services individually

Usage: 

## 1. Add a record 
Add a record through the backend in a folder type page.
The record consists out of 3 fields: 
1. A title (describing who / what gets access for what)
2. An IP list. (At least one) A list (comma separated) of IPs allowing access to an extension or all extensions. 
3. The extension or select Global to allow access to all.

With the following code the requested extension matches IP and extension. If a match is found, access is granted. 

## Add test code to your API
This code results in a false if there is no access granting record 

    if (!RemoteWhitelistController::isHostAllowed('myExtension')) {
        
        // Do access denied stuff
        
    }

Make sure to change the name of your extension, ``myExtension`` in the code above.

## Whats new in this version

2020-04-08
* This version work with TYPO3 v10.3.