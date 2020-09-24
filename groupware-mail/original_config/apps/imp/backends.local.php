<?php
/**
 * This file specifies which mail servers IMP can login to.
 *
 * IMPORTANT: DO NOT EDIT THIS FILE!
 * Local overrides MUST be placed in backends.local.php or backends.d/.
 * If the 'vhosts' setting has been enabled in Horde's configuration, you can
 * use backends-servername.php.
 *
 * Example configuration file that sets a different server name than localhost
 * for the IMAP server:
 *
 * <?php
 * $servers['imap']['hostspec'] = 'imap.example.com';
 *
 * Example configuration file that enables the advanced IMAP server in favor of
 * the simple server and enables 'hordeauth':
 *
 * <?php
 * $servers['imap']['disabled'] = true;
 * $servers['advanced']['disabled'] = false;
 * $servers['advanced']['hordeauth'] = true;
 *
 *
 * Properties that can be set for each server:
 * ===========================================
 *
 * disabled: (boolean) If true, the config entry is disabled.
 *
 * name: (string) This is the name displayed in the server list on the login
 *   screen.
 *
 * hostspec: (string) The hostname/IP address of the mail server to connect to.
 *
 * hordeauth: (mixed) Use Horde authentication?  One of:
 *     - true: [DEFAULT] IMP will attempt to use the user's existing
 *             credentials (the username/password they used to log in to
 *             Horde with) to login to this server.
 *             Everything after and including the first @ in the username
 *             will be stripped off before attempting authentication.
 *     - 'full': The username will be used unmodified.
 *     - false: Don't use Horde authentication; always require separate login.
 *
 * protocol: (string) The server protocol.  One of:
 *     - imap: [DEFAULT] IMAP. Requires a IMAP4rev1 (RFC 3501) compliant
 *               server.
 *     - pop: POP3. Requires a POP3 (RFC 1939) compliant server. All
 *              mailbox options will be disabled (POP3 does not support
 *              mailboxes). Other advanced functions will also be disabled
 *              (e.g. caching, searching, sorting).
 *
 * secure: (mixed) Security method used to connect to the server. One of:
 *     - 'ssl': [DEPRECATED; see below] Use SSL to connect to the server.
 *     - 'tls': [DEFAULT on IMAP; RECOMMENDED] Use TLS to connect to the
 *              server.
 *     - false: [DEFAULT on POP3; NOT RECOMMENED] Do not use any encryption.
 *
 *   The 'ssl' and 'tls' options will only work if you've compiled PHP
 *   with SSL support and the mail server supports secure connections.
 *
 *   The use of 'ssl' is STRONGLY DISCOURAGED. If a secure connection
 *   is needed, 'tls' should be used and the connection should be made
 *   to the base protocol port (110 for POP3, 143 for IMAP).
 *   See: http://wiki2.dovecot.org/SSL
 *
 * port: (integer) The port that the mail service/protocol you selected runs
 *   on. Default values:
 *     - imap (unsecure or w/TLS):  143
 *     - imap (w/SSL):  993 (DEPRECATED - use TLS on port 143)
 *     - pop (unsecure or w/TLS):  110
 *     - pop (w/SSL):  995 (DEPRECATED - use TLS on port 110)
 *
 * maildomain: (string) What to put after the @ when sending mail. This
 *   setting is generally useful when the sending host is different from the
 *   mail receiving host. This setting will also be used to complete
 *   unqualified addresses when composing mail. E.g. If you want all sent
 *   messages to look like:
 *
 *       From: user@example.com
 *
 *   set 'maildomain' to 'example.com'.
 *
 * cache: (mixed) Enables IMAP caching for the server.
 *
 *   Caching is HIGHLY RECOMMENDED. (Do note that if your IMAP server does not
 *   support the CONDSTORE and/or QRESYNC IMAP extensions, flags changed by
 *   another mail agent while the IMP session is active will not be updated.)
 *
 *   The following values are recognized:
 *     - false: [DEFAULT] Caching is disabled
 *     - true: Caching is enabled using the Horde cache (configured in
 *             horde/config/conf.php). (This option is DEPRECATED; use one of
 *             the below options instead.)
 *     - 'cache': Caching is enabled using the Horde cache (configured in
 *                horde/config/conf.php). It is recommended to use either
 *                'hashtable', 'nosql', or 'sql' instead, as these backends
 *                have better performance.
 *                The 'cache_lifetime' parameter (integer) can be specified
 *                to define the lifetime of the cached message data.
 *     - 'hashtable': Caching is enabled using the Horde HashTable driver
 *                    (configured in horde/config/conf.php).
 *                    The 'cache_lifetime' parameter (integer) can be
 *                    specified to define the lifetime of the cached message
 *                    data.
 *     - 'nosql': Caching is enabled using the Horde NoSQL database
 *                (configured in horde/config/conf.php).
 *     - 'sql': Caching is enabled using the Horde SQL database (configured in
 *              horde/config/conf.php).
 *     - A Horde_Imap_Client_Cache_Backend object: Directly configure the
 *                                                 caching backend to use. For
 *                                                 advanced users only.
 *
 * quota: (array) Use this if you want to display a user's quota status. Set
 *   to an empty value to disable quota status (DEFAULT).
 *
 *   To enable, set the 'driver' key to the name of the driver. The 'params'
 *   key can contain optional configuration parameters.
 *
 *   These 'params' keys are available for ALL drivers:
 *     - hide_when_unlimited: (boolean) True if you want to hide quota
 *                            output when the server reports an unlimited
 *                            quota.
 *     - interval: (integer) Update quota information in the UI at this
 *                 interval (in seconds). Defaults to 15 minutes.
 *     - unit: (string) What storage unit the quota messages should be
 *             displayed in.  One of:
 *               - GB
 *               - MB [DEFAULT]
 *               - KB
 *
 *   These are the available drivers, along with their optional parameters:
 *     - hook: Use the quota hook to handle quotas (see imp/config/hooks.php).
 *             All parameters defined for this driver will be passed to the
 *             quota hook function.
 *     - imap: Use the IMAP QUOTA extension to handle quotas. The IMAP server
 *             server must support the QUOTAROOT command to use this driver.
 *             This is the RECOMMENDED way of handling quotas.
 *
 * smtp: (array) SMTP configuration parameters.
 *
 *   For configuration parameters marked with a [*] below, the Horde-wide SMTP
 *   configuration is used by default.
 *
 *   If allowing access to external mail servers (e.g. Gmail), you almost
 *   certainly will want to override the defaults to specify the foreign SMTP
 *   server used to send messages from that given mail domain.
 *
 *   NOTE: By default, IMP will use the authentication credentials used to
 *   login to the current backend. To use the credentials specified by the
 *   Horde-wide SMTP configuration, 'horde_auth' must be true (see below).
 *
 *   These configuration parameters are available:
 *     - debug: (string) If set, enables SMTP debugging. See the 'debug'
 *              parameter below (under the 'Debugging Properties' header)
 *              for acceptable values.
 *     - horde_auth: (boolean) If true, populates the 'password' and
 *                   'username' parameters with the authentication credentials
 *                   used by the Horde-wide SMTP configuration (only if those
 *                   fields are not defined for this backend in IMP).
 *     - host: [*] (string) SMTP server host.
 *     - lmtp: [*] (boolean) If true, the server uses the LMTP protocol.
 *     - localhost: [*] (string) The local hostname.
 *     - password: (string) Password to use for SMTP server authentication.
 *     - port: [*] (integer) SMTP server port.
 *     - secure: [*] (string) Use SSL or TLS to connect.
 *               Possible options:
 *                 - false (No encryption)
 *                 - 'ssl' (Auto-detect SSL version)
 *                 - 'sslv2' (Force SSL version 2)
 *                 - 'sslv3' (Force SSL version 3)
 *                 - 'tls' (TLS) [DEFAULT]
 *                 - 'tlsv1' (TLS direct version 1.x connection to server)
 *                   [@since Horde_Smtp 1.3.0]
 *                 - true (Use TLS, if available) [@since Horde_Smtp 1.2.0]
 *     - timeout: (integer) Connection timeout, in seconds. Defaults to 30
 *                seconds
 *     - username: (string) Username to use for SMTP server authentication.
 *
 * spam: (array) Spam reporting configuration. This array can contain two
 *   keys - 'innocent' and 'spam' - that defines the behavior when a user
 *   flags a message with one of these actions.
 *
 *   The 'display' option (boolean) behaves as follows:
 *     - innocent: If true, the innocent action only appears in the user's
 *                 spam mailbox (default). If false, the action appears in
 *                 all mailboxes.
 *     - spam: If false, the spam action appears in all mailboxes other than
 *             the user's spam mailbox (default). If true, the action appears
 *             in all mailboxes.
 *
 *   These placeholders are available in the options marked *EXPANDABLE* below
 *   and will be expanded at run-time:
 *      - %u: The Horde username.
 *      - %l: The short username (no domain information).
 *      - %d: The domain name.
 *
 *   The following drivers are available (at least one driver must be
 *   configured for the spam options to appear in the UI):
 *
 *     + Email reporting
 *       - email: (string) The e-mail address to use for reporting.
 *       - email_format: (string) Either 'digest' or 'redirect'.
 *         - digest: [DEFAULT; RECOMMENDED] Packages the raw data of all
 *                   messages reported by the user in their marking action and
 *                   sends to the reporting e-mail address in a
 *                   multipart/digest message(s).
 *
 *                   If this option is selected, two additional config options
 *                   are available:
 *
 *                   - digest_limit_msgs: (integer) The maximum number of
 *                                        messages that will be sent in a
 *                                        multpart/digest message. If the
 *                                        number of messages to report exceeds
 *                                        this value, multiple digest messages
 *                                        will be sent. The default is to send
 *                                        a single message. If 0, there is no
 *                                        limit.
 *                   - digest_limit_size: (integer) The maximum size (in
 *                                        bytes) of a single digest message.
 *                                        If the size of messages to report
 *                                        exceeds this value, multiple digest
 *                                        messages will be sent. The default
 *                                        is 10 MB. If 0, there is no limit.
 *
 *         - redirect: Redirects the message to the reporting e-mail address
 *                     Note that this alters the original message's headers
 *                     and may break embedded spam reporting signature
 *                     information contained in the original message.
 *
 *     + Null reporting
 *       - null: (boolean) Whether the action should be considered to be
 *               successful or not. This driver can be used to trigger
 *               post-reporting spam actions (i.e. deleting/moving messages)
 *               if this value is true and no other drivers are configured.
 *
 *     + Program reporting
 *       - program: (string) An external program to report the spam message
 *                  to. Messages will be reported to the program via standard
 *                  input.
 *
 *
 * Properties that only apply to IMAP servers:
 * ===========================================
 *
 * acl: (boolean) Access Control Lists (ACLs).  One of:
 *   - true:  Enable ACLs. (Not all IMAP servers support this feature).
 *   - false:  [DEFAULT] Disable ACLs.
 *
 * admin: (array) Use this if you want to enable mailbox management for
 *   administrators via Horde's user administration interface. The mailbox
 *   management gets enabled if you let IMP handle the Horde authentication
 *   the 'application' authentication driver.  Your IMAP server needs to
 *   support mailbox management via IMAP commands.
 *
 *   Do not define this value if you do not want mailbox management [DEFAULT].
 *
 *   The following parameters are available:
 *     - password: (string) The admin user's password.
 *     - user: (string) The admin user.
 *     - userhierarchy: (string) The hierarchy where user mailboxes are
 *                      stored.
 *
 * autocreate_special: (boolean) If true, automatically create special
 *                     mailboxes on login (see 'special_mboxes')?
 *
 * special_mboxes: (array) The list of mailbox names to use for special
 *   mailboxes. These values override the default preference values for a
 *   backend.
 *
 *   The array keys are the special mailbox type, the array values are the
 *   IMAP mailbox name (UTF-8) to use on the server. Available keys:
 *     - IMP_Mailbox::MBOX_DRAFTS
 *     - IMP_Mailbox::MBOX_SENT
 *     - IMP_Mailbox::MBOX_SPAM
 *     - IMP_Mailbox::MBOX_TEMPLATES
 *     - IMP_Mailbox::MBOX_TRASH
 *
 *   It is also possible to define localized special mailboxes. To do so, use
 *   the array key IMP_Mailbox::MBOX_USERSPECIAL and list the local special
 *   mailboxes in an array, with keys as the IMAP mailbox name (in UTF-8) and
 *   values as the mailbox display label.
 *
 *
 * Debugging properties:
 * =====================
 *
 * debug: (string) If set, will output debug information about the
 *   client/server communication. The value can be any PHP supported wrapper
 *   that can be opened via PHP's fopen() command. This setting should not be
 *   enabled by default on production servers, since the log file will quickly
 *   grow very large.
 *
 *   Example: To output to a file, provide the full path to the file (a bare
 *   string is interpreted by PHP to be a filename). This file must be
 *   writable by the PHP process.
 *
 * debug_raw: (boolean) By default, debugging will only output a short summary
 *   of message body content sent to and received from the server. If you want
 *   the debug stream to output the full, raw data of the client/server
 *   communication, set this option to true.
 *
 *
 * Advanced properties:
 * ====================
 *
 * *** The following options should NOT be set unless you REALLY know what ***
 * *** you are doing! FOR MOST PEOPLE, AUTO-DETECTION OF THESE PARAMETERS  ***
 * *** (the default if the parameters are not set) SHOULD BE USED!         ***
 *
 * atc_structure: (boolean) Use body structure data to determine whether to
 *   flag messages with attachments in the mailbox list? This is a more
 *   accurate algorithm for determining, but is more expensive to generate
 *   this data (especially if not using IMAP and/or not using a caching mail
 *   server). Set to false if worried about performance issues.
 *
 * capability_ignore: [IMAP only] (array) A list of IMAP capabilites to
 *   ignore, even if they are supported on the server. The capability names
 *   should be in all capitals. This option may be useful, for example, if it
 *   is known that a certain capability is buggy on the given server.
 *   Otherwise, all available and supported IMAP capabilities will be (and
 *   should be) used.
 *
 * comparator: [IMAP only] (string) The search comparator to use instead of
 *   the default IMAP server comparator (e.g. for sorting text fields). See
 *   RFC 4790 [3.1] - "collation-id" - for the format. Your IMAP server must
 *   support the I18NLEVEL extension. By default, the server default
 *   comparator is used.
 *
 * id: [IMAP only] (array) Send ID information to the IMAP server. This must
 *   be an array with the keys being the fields to send and the values being
 *   the associated values. Your IMAP server must support the ID extension.
 *   See RFC 2971 [3.3] for a list of defined field values.
 *
 * import_limit: [IMAP only] (integer) The maximum number of messages a user
 *   can import. Importing large mailboxes via the IMAP APPEND command is
 *   potentially a resource-intensive operation, and some IMAP servers (e.g.
 *   Dovecot 2.2) can be extremely slow in importing. By default, limit
 *   importing to 2500 messages. Set this to 0 to enforce no message limit.
 *
 * lang: [IMAP only] (array) A list of languages (in priority order) to be
 *   used to display human readable messages returned by the IMAP server. Your
 *   IMAP server must support the LANGUAGE extension. By default, IMAP
 *   messages are output in the IMAP server default language.
 *
 * namespace: [IMAP only] (array) The list of namespaces that exist on the
 *   server. Example:
 *
 *     array('#shared/', '#news/', '#public/')
 *
 *   This parameter should only be used if you want to allow access to names
 *   namespaces that may not be publicly advertised by the IMAP server (see
 *   RFC 2342 [3]). These additional namespaces will be ADDED to the list of
 *   available namespaces returned by the server.
 *
 * preferred: (string | array) Useful if you want to use the same backends.php
 *   file for different machines. If the hostname of the IMP machine is
 *   identical to one of those in the preferred list, then that entry will be
 *   selected by default on the login screen. Otherwise the first entry in the
 *   list is selected.
 *
 * sort_force: (boolean) By default, IMP only allows sorting by criteria
 *   other than arrival time if using IMAP and the remote IMAP server supports
 *   the SORT extension (RFC 5256). If this setting is true, IMP will
 *   implement sorting on the web server. However, this requires that the
 *   selected sort criteria be downloaded from the remote server for EVERY
 *   message in a mailbox before the mailbox can be displayed. For mailboxes
 *   that contain more than a few hundred messages, this can be a tremendously
 *   expensive operation. Enable sorting on these installations at your peril.
 *
 * thread: [IMAP only] (string) Set the preferred thread sort algorithm. This
 *   algorithm must be supported by the remote server. By default, IMP
 *   attempts to use REFERENCES sorting and, if this is not available, will
 *   fallback to ORDEREDSUBJECT sorting performed by Horde on the local server.
 *
 * timeout: (integer) Set the server timeout (in seconds).
 */

/* Example configurations: */

// IMAP server

$servers['imap'] = array(
    'disabled' => false,
    'name' => 'IMAP Server',
    'hostspec' => 'horde_dovecot',
    'hordeauth' => true,
    'protocol' => 'imap',
    'port' => 143,
    'secure' => 'tls',
    'maildomain' => 'horde.dev.local',
    'smtp' => array(
        'auth' => true,
        'debug' => false,
        'horde_auth' => true,
        'localhost' => 'localhost',
        'host' => 'horde_postfix',
        'port' => 587,
        'secure' => 'none',
        'lmtp' => false,
    ),
);
