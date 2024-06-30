// common.js
// Copyright 2001-2003 by Christopher Heng. All rights reserved.
// $Id: common.js 2.3 2003/04/29 11:49:36 chris Exp $

function framebreaker()
{	// see http://www.thesitewizard.com/archive/framebreak.shtml
	// for an explanation of this script and how to use it on your own site
	if (top.location != location) {
		top.location.href = document.location.href ;
	}
}
