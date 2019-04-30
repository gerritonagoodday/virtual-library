Joomla Virtual Library README
-----------------------------
$Id$

Author: Gerrit Hoekstra <gerrit@hoekstra.co.uk>
        www.hoekstra.co.uk

Virtual Library Introduction
----------------------------

This Joomla component runs a Virtual Library that attempts to simulate real library, but without the musty smell and the officious librarian in horn-rimmed lasses and beehive hairstyle who goes Shhhhhhhhhhhhh!  to hapless patrons at the slightest accoustic infraction. It does this and more...

Intr'Acte
---------

The Virtual Library component lets you create, maintain and host a Virtual Library of ebooks, reference web sites and real books. You can upload and delete ebooks, categorise your collection of ebooks so that browsing your collection is more enjoyable. You can sort them using various criteria, and ultimately, you can peruse, read and enjoy them.

True to the Internet idiom, you can refer to ebooks stored on other sites too. Since ebooks can, amongst others, be in the form of web pages, books in your library can also be web pages on a website.

Your Virtual Library need not contain ebooks only - it can also contain reference to real books sitting in a real library somewhere, such as in your school library or in your very own book case.

What else does it do?
---------------------

    * If you want to have a proper book browsing experience, scan in the front cover of front page of printed publications or snapshot of the front cover of the ebook, and upload this too.
    * You can share your full or partial collection of ebooks with others and import their ebook collection to yours using the BibTeX file format, regardless of where the ebooks are actually hosted. A BibTeX file is a plain text file with TeX formatting, which is used by document writers and academics to cite references and share their references between projetcs. The BibTeX file is usually appended to academic publications written in TeX.
    * All ebook file formats are supported. Whatever software you use to read the various types of ebooks is your business. Fortunately, most  ebook-readers have some form of Internet browser integration and most ebook readers are free (as in beer). Needless to say: avoid ebook formats that do not have free ebook readers available.

Why is this useful?
-------------------

    * Because it is nice to display a collection of books ready for reading, much in the same way as it is nice to have a book case with books sorted into subject matter.
    * You can seach for authors, pubication titles and subject.
    * You can search the content of your ebook collection. For the time being, this is mostly dependent on what key words and abstracts you have for each publication. Full content search of your library is still a while off.
    * It is a team repository for reference books.
    * Is is a bibliographical database for research projects. The filtered content of the collection can be exported to a BibTeX file. Likewise, you can import other project's BibTeX files to add to you bibliography.


Potential Applications - what do I do with my Wonderful eBook Collection?
-------------------------------------------------------------------------

Some potential uses of a Virtual Library are:

    * Technical Consultants who need to keep their references on hand when moving between site, without having to drag piles of books around with them
    * Project-based collection of reference works
    * Manage a school library on a schools' intranet
    * Sorting and enjoying your own collection of books
    * Hosting your ebook collection for others to enjoy
    * Peruse the publication in the comfort of wherever you are whilst noisily eating Cheezy Wotsits.

Anticipated features in the future releases
-------------------------------------------

Perhaps by the time that you read this you will be able to do the following, although I am a lazy person who is easily gratified by small successes, so don't hold your breath:

    * Library book shelf look, books stacked like on a real book shelf, some vertical, some horizontal,
    * Bulk importing  and exporting of ebooks with a BibTeX file.
    * Warehousing feature - Manage the physical location of printed publications in your 'real' library
    * Geo-feature - Manage the geographical location of printed publications in other 'real' libraries.
    * Content searching of your ebooks.
    * Automatic extraction of front covers of uploaded ebooks.
    * Support for Joomla 1.5
    * Multilanguage support
    * Remove cruft from ebooks. Vanity dictates that ebooks distributed on torrents require the first few pages to depict someone's dog or even uglier girlfriend. Enough of this, I say!

Great ideas for other developers
--------------------------------

The question came up of: "Oooh, can't we run a real library on this thing?". Well, no. This is beyond the scope of this component. But if someone would like to put together a Joomla component for this, then it would be very nice. For full integration with this Virtual Library component, some interfaces will need to be published which I will be happy to assist with.


Component's ancestry
--------------------

It is based on  Mark Austin's BibTex component V1.3  http://www.everythingthatiknowabout.com, which in turn is based on the Joomla Glossary component (http://www.remository.com), which in turn is based on a Mambo component, which appears to be code hacked from the original Mambo framework. And so on - you know how Open Source works.

The virtual library serves as a bibliographical database and retains all the original features of Mark Austin's BibTex component 1.3. After all, the importing and exporting of biliographical references gives a virtual library something that a real library can't offer.

Installation
------------

    * You have Joomla installed on your webserver, right?
    * If the Virtual Library component already exists, then you must uninstall it first. Your existing ebooks and publication cover images will remain intact. However, your databases will be recreated.
    * If you want to preserve the content of your database, export your library to a BibTeX file before you do anything else and then reimport it once you have installed the new version.
    * If you want a clean re-install, see the Uninstall section below.
    * The ZIP archive com_virtuallib_*..zip  is installed using the standard Joomla Component Installer mechanism.

Uninstallation
--------------

Uninstall the component using the standard Joomla component Uninstall facility. If you want to remove all traces of this component, drop the following tables in mySQL:

    * [prefix]_virtuallib
    * [prefix]_virtuallib_auth
    * [prefix]_virtuallib_bibtex
    * [prefix]_virtuallib_categories
    * [prefix]_virtuallib_location

 - where [prefix] is your chosen table prefix when you installed Joomla on your server. By default, it is "mos".

Your ebooks and publication cover images reside by default in  ~/components/com_virtuallib, so remove this directory:

    * rm -fr /components/com_virtuallib

Support
-------

www.hoekstra.co.uk

Changelog
---------

None yet.

Known bugs
----------

UTF-8 east asian bibtex files are not loaded correctly by the bibtex file reader, these references should be copied and pasted into the textbox input rather than loaded by file. Basically, Joomla 1.0.XX does not do UTF-8 very well. Wait for a Joomla 1.5-compatible release of this component

Licensing
---------

This is the brave new world of open source where giants cower in fear of the little man who releases a nice bit of usefull free software to the world. You are of course free to hack this thing to pieces, to completely bastardize it and to misuse it to suit your wicked purposes under the terms of the GNU license.
