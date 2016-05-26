/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.dialog.add( 'smiley', function( editor ) {
	var config = editor.config,
		lang = editor.lang.smiley,
		images = config.smiley_images,
		columns = config.smiley_columns || 8,
		i;

	// Simulate "this" of a dialog for non-dialog events.
	// @type {CKEDITOR.dialog}
	var dialog;
	var onClick = function( evt ) {
			var target = evt.data.getTarget(),
				targetName = target.getName();

			if ( targetName == 'a' )
				target = target.getChild( 0 );
			else if ( targetName != 'img' )
				return;

			var src = target.getAttribute( 'cke_src' ),
				title = target.getAttribute( 'title' );

			var img = editor.document.createElement( 'img', {
				attributes: {
					src: src,
					'data-cke-saved-src': src,
					title: title,
					alt: title,
					width: target.$.width,
					height: target.$.height
				}
			} );

			editor.insertElement( img );

			dialog.hide();
			evt.data.preventDefault();
		};

	var onKeydown = CKEDITOR.tools.addFunction( function( ev, element ) {
		ev = new CKEDITOR.dom.event( ev );
		element = new CKEDITOR.dom.element( element );
		var relative, nodeToMove;

		var keystroke = ev.getKeystroke(),
			rtl = editor.lang.dir == 'rtl';
		switch ( keystroke ) {
			// UP-ARROW
			case 38:
				// relative is TR
				if ( ( relative = element.getParent().getParent().getPrevious() ) ) {
					nodeToMove = relative.getChild( [ element.getParent().getIndex(), 0 ] );
					nodeToMove.focus();
				}
				ev.preventDefault();
				break;
				// DOWN-ARROW
			case 40:
				// relative is TR
				if ( ( relative = element.getParent().getParent().getNext() ) ) {
					nodeToMove = relative.getChild( [ element.getParent().getIndex(), 0 ] );
					if ( nodeToMove )
						nodeToMove.focus();
				}
				ev.preventDefault();
				break;
				// ENTER
				// SPACE
			case 32:
				onClick( { data: ev } );
				ev.preventDefault();
				break;

				// RIGHT-ARROW
			case rtl ? 37 : 39:
				// relative is TD
				if ( ( relative = element.getParent().getNext() ) ) {
					nodeToMove = relative.getChild( 0 );
					nodeToMove.focus();
					ev.preventDefault( true );
				}
				// relative is TR
				else if ( ( relative = element.getParent().getParent().getNext() ) ) {
					nodeToMove = relative.getChild( [ 0, 0 ] );
					if ( nodeToMove )
						nodeToMove.focus();
					ev.preventDefault( true );
				}
				break;

				// LEFT-ARROW
			case rtl ? 39 : 37:
				// relative is TD
				if ( ( relative = element.getParent().getPrevious() ) ) {
					nodeToMove = relative.getChild( 0 );
					nodeToMove.focus();
					ev.preventDefault( true );
				}
				// relative is TR
				else if ( ( relative = element.getParent().getParent().getPrevious() ) ) {
					nodeToMove = relative.getLast().getChild( 0 );
					nodeToMove.focus();
					ev.preventDefault( true );
				}
				break;
			default:
				// Do not stop not handled events.
				return;
		}
	} );

	// Build the HTML for the smiley images table.
	var labelId = CKEDITOR.tools.getNextId() + '_smiley_emtions_label';
	var html = [
		'<div>' +
		'<span id="' + labelId + '" class="cke_voice_label">' + lang.options + '</span>',
		'<table role="listbox" aria-labelledby="' + labelId + '" style="width:100%;height:100%;border-collapse:separate;" cellspacing="2" cellpadding="2"',
		CKEDITOR.env.ie && CKEDITOR.env.quirks ? ' style="position:absolute;"' : '',
		'><tbody>'
	];

	var size = images.length;
	var colspan = 1;
	for (var z in images) {
	
		var section = images[z];
	
		if(colspan > 1){
			html.push( '<tr><th colspan="10" style="height:14px;"></th></tr>' );
		}
	
		for (var j in section) {
		
			var image = section[j];
			html.push( '<tr role="presentation">' );
			
			for (var i in image) { 

				var smileyLabelId = 'cke_smile_label_' + i + '_' + CKEDITOR.tools.getNextNumber();
				html.push(
					'<td colspan="'+colspan+'" class="cke_dark_background cke_centered" style="vertical-align: middle;" role="presentation">' +
					'<a href="javascript:void(0)" role="option"', ' aria-posinset="' + ( i + 1 ) + '"', ' aria-setsize="' + size + '"', ' aria-labelledby="' + smileyLabelId + '"',
					' class="cke_smile cke_hand" tabindex="-1" onkeydown="CKEDITOR.tools.callFunction( ', onKeydown, ', event, this );">',
					'<img class="cke_hand" title=""' +
					' cke_src="', CKEDITOR.tools.htmlEncode( config.smiley_path + image[ i ] ), '" alt=""',
					' src="', CKEDITOR.tools.htmlEncode( config.smiley_path + image[ i ] ), '"',
					// IE BUG: Below is a workaround to an IE image loading bug to ensure the image sizes are correct.
					( CKEDITOR.env.ie ? ' onload="this.setAttribute(\'width\', 2); this.removeAttribute(\'width\');" ' : '' ), '>' +
					//'<span id="' + smileyLabelId + '" class="cke_voice_label">' + config.smiley_descriptions[ i ] + '</span>' +
					'</a>', '</td>'
				);
			}
			html.push( '</tr>' );
		}
		colspan++;
	} 
	
	
	/*
	var size = images.length;
	for ( i = 0; i < size; i++ ) {
		if ( i % columns === 0 )
			html.push( '<tr role="presentation">' );

		var smileyLabelId = 'cke_smile_label_' + i + '_' + CKEDITOR.tools.getNextNumber();
		html.push(
			'<td class="cke_dark_background cke_centered" style="vertical-align: middle;" role="presentation">' +
			'<a href="javascript:void(0)" role="option"', ' aria-posinset="' + ( i + 1 ) + '"', ' aria-setsize="' + size + '"', ' aria-labelledby="' + smileyLabelId + '"',
			' class="cke_smile cke_hand" tabindex="-1" onkeydown="CKEDITOR.tools.callFunction( ', onKeydown, ', event, this );">',
			'<img class="cke_hand" title="', config.smiley_descriptions[ i ], '"' +
			' cke_src="', CKEDITOR.tools.htmlEncode( config.smiley_path + images[ i ] ), '" alt="', config.smiley_descriptions[ i ], '"',
			' src="', CKEDITOR.tools.htmlEncode( config.smiley_path + images[ i ] ), '"',
			// IE BUG: Below is a workaround to an IE image loading bug to ensure the image sizes are correct.
			( CKEDITOR.env.ie ? ' onload="this.setAttribute(\'width\', 2); this.removeAttribute(\'width\');" ' : '' ), '>' +
			'<span id="' + smileyLabelId + '" class="cke_voice_label">' + config.smiley_descriptions[ i ] + '</span>' +
			'</a>', '</td>'
		);

		if ( i % columns == columns - 1 )
			html.push( '</tr>' );
	}*/

	/*if ( i < columns - 1 ) {
		for ( ; i < columns - 1; i++ )
			html.push( '<td></td>' );
		html.push( '</tr>' );
	}*/

	html.push( '</tbody></table></div>' );

	var smileySelector = {
		type: 'html',
		id: 'smileySelector',
		html: html.join( '' ),
		onLoad: function( event ) {
			dialog = event.sender;
		},
		focus: function() {
			var self = this;
			// IE need a while to move the focus (#6539).
			setTimeout( function() {
				var firstSmile = self.getElement().getElementsByTag( 'a' ).getItem( 0 );
				firstSmile.focus();
			}, 0 );
		},
		onClick: onClick,
		style: 'width: 100%; border-collapse: separate;'
	};

	return {
		title: editor.lang.smiley.title,
		minWidth: 544,
		minHeight: 400,
		contents: [ {
			id: 'social',
			label: '',
			title: '',
			expand: true,
			padding: 0,
			elements: [
				smileySelector
			]
		} ],
		buttons: [ CKEDITOR.dialog.cancelButton ]
	};
} );


CKEDITOR.config.smiley_images = [
    [
        ["icons/0000_facebook.jpg","icons/0001_pinterest.jpg","icons/0002_twitter.jpg","icons/0003_google+.jpg","icons/0004_youtube.jpg","icons/0005_stumbleupon.jpg","icons/0006_tumblr.jpg","icons/0007_fiendfeed.jpg","icons/0008_scoopit .jpg","icons/0009_weheartit.jpg"],
        ["icons/0010_behance.jpg","icons/0011_society6.jpg","icons/0012_last.fm.jpg","icons/0013_mister wong.jpg","icons/0014_freshbump.jpg","icons/0015_fancy.jpg","icons/0016_buzzfeed.jpg","icons/0017_9gag.jpg","icons/0018_flickr.jpg","icons/0019_vimeo.jpg"],
        ["icons/0020_designfloat.jpg","icons/0021_designmoo.jpg","icons/0022_deviantart.jpg","icons/0023_dribbble.jpg","icons/0024_yigg.de.jpg","icons/0025_virb.jpg","icons/0026_linkedin.jpg","icons/0027_reddit.jpg","icons/0028_feedburner.jpg","icons/0029_instagram.jpg"],
        ["icons/0030_odnoklassniki.jpg","icons/0031_vkontakte.jpg","icons/0032_yandex.jpg","icons/0033_mail.ru.jpg","icons/0034_livejournal.jpg","icons/0035_habrahabr.ru.jpg","icons/0036_visualize.us .jpg","icons/0037_newsvine.jpg","icons/0038_blogger.jpg","icons/0039_wordpress.jpg"],
        ["icons/0040_forrst.jpg","icons/0041_blinklist.jpg","icons/0042_bebo.jpg","icons/0043_viddler.jpg","icons/0044_ebay.jpg","icons/0045_amazon.jpg","icons/0046_edmodo.jpg","icons/0047_dzone.jpg","icons/0048_dotnetshoutout.jpg","icons/0049_diiigo.jpg"],
        ["icons/0050_fresqui.jpg","icons/0051_formspring.jpg","icons/0052_folkd.jpg","icons/0053_fashiolista.jpg","icons/0054_fark.jpg","icons/0055_evernote.jpg","icons/0056_connotea.jpg","icons/0057_dealsplus.jpg","icons/0058_jumptags.jpg","icons/0059_allvoices.jpg"],
        ["icons/0060_fwisp.jpg","icons/0061_arto.jpg","icons/0062_identi.ca.jpg","icons/0063_hyves.jpg","icons/0064_picasa.jpg","icons/0065_google buzz.jpg","icons/0066_googlebookmarks.jpg","icons/0067_translate.jpg","icons/0068_reader.jpg","icons/0069_google.jpg"],
        ["icons/0070_myspace.jpg","icons/0071_squidoo.jpg","icons/0072_yahoo.jpg","icons/0073_meneame.jpg","icons/0074_netlog.jpg","icons/0075_instapaper.jpg","icons/0076_linkagogo.jpg","icons/0077_kaboodle.jpg","icons/0078_n4g.jpg","icons/0079_bookmarks.fr.jpg"],
        ["icons/0080_baidu.jpg","icons/0081_speedtile.jpg","icons/0082_sonico.jpg","icons/0083_slashdot.jpg","icons/0084_sina.jpg","icons/0085_segnalo.jpg","icons/0086_orkut.jpg","icons/0087_hatena.jpg","icons/0088_voxopolis.jpg","icons/0089_corank.jpg"],
        ["icons/0090_nujij.jpg","icons/0091_viadeo.jpg","icons/0092_typepad.jpg","icons/0093_technorati.jpg","icons/0094_stumpedia.jpg","icons/0095_startlap.jpg","icons/0096_mind body green.jpg","icons/0097_gamespot.jpg","icons/0098_gabbr.jpg","icons/0099_friendster.jpg"],
        ["icons/0100_box.jpg","icons/0101_ask.jpg","icons/0102_aim.jpg","icons/0103_adfty.jpg","icons/0104_yammer.jpg","icons/0105_xing.jpg","icons/0106_xerpi.jpg","icons/0107_xanga.jpg","icons/0108_dailyme.jpg","icons/0109_expression.com.jpg"],
        ["icons/0110_oknotizie.jpg","icons/0111_netvouz.jpg","icons/0112_mozillaca.jpg","icons/0113_linkatopia.jpg","icons/0114_plurk.jpg","icons/0115_plaxo.jpg","icons/0116_jamespot.jpg","icons/0117_technotizie.it.jpg","icons/0118_hello txt.jpg","icons/0119_nowpublic.jpg"],
        ["icons/0120_protopage.jpg","icons/0121_posterous.jpg","icons/0122_sphinn.jpg","icons/0123_sitejot.jpg","icons/0124_shoutwire.jpg","icons/0125_phonefavs.jpg","icons/0126_readitlater.jpg","icons/0127_newstrust.jpg","icons/0128_youmob.jpg","icons/0129_readernaut.jpg"],
        ["icons/0130_swik.jpg","icons/0131_yelp.jpg","icons/0132_citeulike.jpg","icons/0133_chiq.jpg","icons/0134_care2.jpg","icons/0135_scribd.jpg","icons/0136_yoolink.jpg","icons/0137_buddymarks.jpg","icons/0138_blogmarks.jpg","icons/0139_wists.jpg"],
        ["icons/0140_funp.jpg","icons/0141_bx.businessweek.com.jpg","icons/0142_meetup.jpg","icons/0143_zootool.jpg","icons/0144_networkedblogs.jpg","icons/0145_massenger.jpg","icons/0146_skype.jpg","icons/0147_brainify.jpg","icons/0148_startaid.jpg","icons/0149_buffer.jpg"],
        ["icons/0150_twitpic.jpg","icons/0151_gowalla.jpg","icons/0152_blip.pl.jpg","icons/0153_paypal.jpg","icons/0154_rss.jpg","icons/0155_socialvibe.jpg","icons/0156_jquery.jpg","icons/0157_joomla.jpg","icons/0158_wix.jpg","icons/0159_drupal.jpg"],
        ["icons/0160_ember.js.jpg","icons/0161_steam.jpg","icons/0162_playfire.jpg","icons/0163_audioboo.jpg","icons/0164_wakoopa.jpg","icons/0165_soundcloud.jpg","icons/0166_grooveshark.jpg","icons/0167_lockerz.jpg","icons/0168_cargo.jpg","icons/0169_dopplr.jpg"]
    ],

    [
        ["psdsite_04/VK.png","psdsite_04/FB.png","psdsite_04/G.png","psdsite_04/lv.png","psdsite_04/mail.png"],
        ["psdsite_04/email.png","psdsite_04/Odnoklasniki.png","psdsite_04/RSS.png","psdsite_04/Twitter.png","psdsite_04/ya.png"],

        ["psdsite_10/VK.png","psdsite_10/FB.png","psdsite_10/G.png","psdsite_10/lv.png","psdsite_10/mail.png"],
        ["psdsite_10/email.png","psdsite_10/Odnoklasniki.png","psdsite_10/RSS.png","psdsite_10/Twitter.png","psdsite_10/ya.png"],

        ["psdsite.ru/VK.png","psdsite.ru/FB.png","psdsite.ru/G.png","psdsite.ru/lv.png","psdsite.ru/mail.png"],
        ["psdsite.ru/email.png","psdsite.ru/Odnoklasniki.png","psdsite.ru/RSS.png","psdsite.ru/Twitter.png","psdsite.ru/ya.png"],

        ["psdsite_02/VK.png","psdsite_02/FB.png","psdsite_02/Google.png","psdsite_02/lv.png","psdsite_02/mail.png"],
        ["psdsite_02/email.png","psdsite_02/Odnoklasniki.png","psdsite_02/RSS.png","psdsite_02/Twitter.png","psdsite_02/ya.png"],

        ["psdsite_03/VK.png","psdsite_03/FB.png","psdsite_03/G.png","psdsite_03/lv.png","psdsite_03/mail.png"],
        ["psdsite_03/email.png","psdsite_03/Odnoklasniki.png","psdsite_03/RSS.png","psdsite_03/Twitter.png","psdsite_03/ya.png"],

        ["psdsite_05/VK.png","psdsite_05/FB.png","psdsite_05/G.png","psdsite_05/lv.png","psdsite_05/mail.png"],
        ["psdsite_05/email.png","psdsite_05/Odnoklasniki.png","psdsite_05/RSS.png","psdsite_05/Twitter.png","psdsite_05/ya.png"],

        ["psdsite_06/VK.png","psdsite_06/FB.png","psdsite_06/G.png","psdsite_06/lv.png","psdsite_06/mail.png"],
        ["psdsite_06/email.png","psdsite_06/Odnoklasniki.png","psdsite_06/RSS.png","psdsite_06/Twitter.png","psdsite_06/ya.png"],

        ["psdsite_07/VK.png","psdsite_07/FB.png","psdsite_07/G.png","psdsite_07/lv.png","psdsite_07/mail.png"],
        ["psdsite_07/email.png","psdsite_07/Odnoklasniki.png","psdsite_07/RSS.png","psdsite_07/Twitter.png","psdsite_07/ya.png"],

        ["psdsite_08/VK.png","psdsite_08/FB.png","psdsite_08/G.png","psdsite_08/lv.png","psdsite_08/mail.png"],
        ["psdsite_08/email.png","psdsite_08/Odnoklasniki.png","psdsite_08/RSS.png","psdsite_08/Twitter.png","psdsite_08/ya.png"],

        ["psdsite_11/VK.png","psdsite_11/FB.png","psdsite_11/G.png","psdsite_11/lv.png","psdsite_11/mail.png"],
        ["psdsite_11/email.png","psdsite_11/Odnoklasniki.png","psdsite_11/RSS.png","psdsite_11/Twitter.png","psdsite_11/ya.png"],

        ["psdsite_12/VK.png","psdsite_12/FB.png","psdsite_12/G.png","psdsite_12/lv.png","psdsite_12/mail.png"],
        ["psdsite_12/email.png","psdsite_12/Odnoklasniki.png","psdsite_12/RSS.png","psdsite_12/Twitter.png","psdsite_12/ya.png"],

        ["psdsite_13/VK.png","psdsite_13/FB.png","psdsite_13/G.png","psdsite_13/lv.png","psdsite_13/mail.png"],
        ["psdsite_13/email.png","psdsite_13/Odnoklasniki.png","psdsite_13/RSS.png","psdsite_13/Twitter.png","psdsite_13/ya.png"],

        ["psdsite_14/VK.png","psdsite_14/FB.png","psdsite_14/G.png","psdsite_14/lv.png","psdsite_14/mail.png"],
        ["psdsite_14/email.png","psdsite_14/Odnoklasniki.png","psdsite_14/RSS.png","psdsite_14/Twitter.png","psdsite_14/ya.png"],

        ["psdsite_15/VK.png","psdsite_15/FB.png","psdsite_15/G.png","psdsite_15/lv.png","psdsite_15/mail.png"],
        ["psdsite_15/email.png","psdsite_15/Odnoklasniki.png","psdsite_15/RSS.png","psdsite_15/Twitter.png","psdsite_15/ya.png"],

        ["flat_icons/VK.png","flat_icons/FB.png","flat_icons/G.png","flat_icons/lv.png","flat_icons/mail.png"],
        ["flat_icons/email.png","flat_icons/Odnoklasniki.png","flat_icons/RSS.png","flat_icons/Twitter.png","flat_icons/ya.png"]
    ]
];