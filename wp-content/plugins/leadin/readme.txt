=== LeadIn ===
Contributors: andygcook, nelsonjoyce
Tags:  inbound, analytics, crm
Requires at least: 3.7
Tested up to: 3.8
Stable tag: 0.4.5

LeadIn - WordPress CRM

== Description ==

LeadIn is an easy-to-use CRM plugin for WordPress that helps you better understand your web site visitors as individual people.

LeadIn automatically sends you a detailed email report whenever a visitor fills out a form on your website. Each email report includes where the visitor came from, what pages she viewed, social profile links and more.

All of this data is also stored and viewable in one place in the WordPress admin backend.

Setup is easy — all you have to do is install the plugin, set an email address for where to send your leads, and you're done.

== Contact reports include: ==

__Original referring url__ - The URL the visitor used to come to your website (e.g. Google, MailChimp, Facebook, etc)

__Page view history__ - The exact pages the visitor saw

__First page visited__ - The first page the visitor landed on when coming to your website

__Form submission URL__ - The URL the visitor was on when the contact form was submitted

__Profile avatar__ - A picture from a social media profile

__Timeline view__ - Timeline of each action the visitor took on your website

== Installation ==

1. Upload the 'leadin' folder to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Add an email address under 'LeadIn' in your settings panel

== FAQ ==

= How does LeadIn integrate with my forms? =

LeadIn automatically integrates with your contact and comment forms that contain an email address field on your web site. There's no setup required.

= When does LeadIn create a contact in my CRM? =

LeadIn creates a new contact in your CRM whenever an email address is detected in your visitor's form submission.

= Which contact form building plugins are supported? =

LeadIn is intended to work with any HTML form out of the box, but does not support forms created by Javascript or loaded through an iFrame. 

To ensure quality we've tested the most popular WordPress form builder plugins.

= Tested + supported: =

- Contact Form 7
- JetPack
- Fast Secure Contact Form
- Contact Form
- Gravity Forms
- Formidable
- Ninja Forms
- Contact Form Clean and Simple

= Tested + unsupported: =

- Wufoo
- HubSpot
- Easy Contact Forms
- Disqus comments

== Screenshots ==

1. Individual contact history
2. Contacts list
3. Sample email report

== Changelog ==

Current version: 0.4.5
Current version release: 2013-01-30

= 0.4.5 (2013.01.30) =
= Enhancements =
- Integration with LeadIn Subscribe

= 0.4.4 (2013.01.24) =
- Bug fixes
- Bind submission tracking on buttons and images inside of forms instead of just submit input types

= Enhancements =
- Change out screenshots to obfiscate personal information

= 0.4.3 (2013.01.13) =
- Bug fixes
- Fixed LeadIn form submission inserts for comments
- Resolved various silent PHP warnings in administrative dashboard
- Fixed LeadIn updater class to be compatible with WP3.8
- Improved contact merging logic to be more reliable

= Enhancements =
- Improved onboarding flow
- Optimized form submission catching + improved performance

= 0.4.2 (2013.12.30) =
- Bug fixes
- Change 'contact' to 'lead' in the contacts table
- Fixed emails always sending to the admin_email
- Tie historical events to new lead when an email is submitted multiple times with different tracking codes
- Select leads, commenters and subscribers on distinct email addresses
- Fixed timeline order to show visit, then a form submission, then subsequent visits

= Enhancements =
- Added url for each page views in the contact timeline
- Added source for each visit event
- Tweak colors for contact timeline
- Default the LeadIn menu to the contacts page

= 0.4.1 (2013.12.18) =
- Bug fixes
- Removed LeadIn header from the contact timeline view
- Updated the wording on the menu view picker above contacts list
- Remove pre-mp6 styles if MP6 plugin is activated
- Default totals leads/comments = 0 when leads table is empty instead of printing blank integer
- Legacy visitors in table have 0 visits because session support did not exist. Default to 1
- Update ouput for the number of comments to be equal to total_comments, not total_leads
- Added border to pre-mp6 timeline events

= 0.4.0 (2013.12.16) =
- Bug fixes
- Block admin comment replies from creating a contact
- Fixed faulty sorting by Last visit + Created on dates in contacts list

= Enhancements =
- Timeline view of a contact history
- New CSS styles for contacts table
- Multiple email address support for new lead/comment emails
- Integration + testing for popular WordPress form builder plugins
- One click updates for manually hosted plugin

= 0.3.0 (2013.12.09) =
- Bug fixes
- HTML encoded page titles to fix broken HTML characters
- Strip slashes from page titles in emails

= Enhancements =
- Created separate LeadIn menu in WordPress admin
- CRM list of all contacts
- Added ability to export list of contacts
- LeadIn now distinguishes between a contact requests and comment submissions
- Added link to CRM list inside each contact/comment email

= 0.2.0 (2013.11.26) =
- Bug fixes
- Broke up page view history by session instead of days
- Fixed truncated form submission titles
- Updated email headers

= Enhancements =
- Plugin now updates upon activation and keeps record of version
- Added referral source to each session
- Added link to page for form submissions
- Updated email subject line
- Added social media avatars to emails

= 0.1.0 (2013.11.22) =
- Plugin released