'use strict';

var SfProjectPage = function() {
	this.urlprefix = '/app/sfchecks';
	
	this.testData = {
			simpleUsx1 : '<usx version="2.0"> <chapter number="1" style="c" /> <verse number="1" style="v" /> <para style="q1">Blessed is the man</para> <para style="q2">who does not walk in the counsel of the wicked</para> <para style="q1">or stand in the way of sinners</para> </usx>',
			longUsx1   : '<?xml version="1.0" encoding="utf-8"?> <usx version="2.0"> <book code="JHN" style="id">43-JHN-kjv.sfm The King James Version of the Holy Bible Wednesday, October 14, 2009</book> <para style="ide">UTF-8</para> <para style="h">John</para> <para style="mt">The Gospel According to St. John</para> <chapter number="1" style="c" /> <para style="p"> <verse number="1" style="v" />In the beginning was the Word, and the Word was with God, and the Word was God. <verse number="2" style="v" />The same was in the beginning with God. <verse number="3" style="v" />All things were made by him; and without him was not any thing made that was made. <verse number="4" style="v" />In him was life; and the life was the light of men. <verse number="5" style="v" />And the light shineth in darkness; and the darkness comprehended it not.</para> <para style="p" /> <chapter number="2" style="c" /> <para style="p"> <verse number="1" style="v" />And the third day there was a marriage in Cana of Galilee; and the mother of Jesus was there: <verse number="2" style="v" />And both Jesus was called, and his disciples, to the marriage. <verse number="3" style="v" />And when they wanted wine, the mother of Jesus saith unto him, They have no wine. <verse number="4" style="v" />Jesus saith unto her, <char style="wj">Woman, what have I to do with thee? mine hour is not yet come. </char> <verse number="5" style="v" />His mother saith unto the servants, Whatsoever he saith unto you, do <char style="add">it. </char> <verse number="6" style="v" />And there were set there six waterpots of stone, after the manner of the purifying of the Jews, containing two or three firkins apiece.  </para> </usx>'
	};

	this.innerMarginForm = element(by.id('insideMarginInput'));
	this.outerMarginForm = element(by.id('outsideMarginInput'));
	this.topMarginForm = element(by.id('topMarginInput'));
	this.bottomMarginForm = element(by.id('bottomMarginInput'));
	
	this.marginDiv = element(by.id('pageLeftLayout'));
	
	//columns 
	this.columnsTab = element(by.css("[heading='Columns']"));
	this.twoBodyColCB = element.all(by.css("[type='checkbox']")).get(0);
	this.twoTitleColCB = element.all(by.css("[type='checkbox']")).get(1);
	this.TwoIntroColCB = element.all(by.css("[type='checkbox']")).get(2);
	this.ColRuleCB = element.all(by.css("[type='checkbox']")).get(3);
	
	//header 
	this.headerTab = element(by.css("[heading='Header']"));
	this.runningHeadCB = element.all(by.css("[type='checkbox']")).get(4);
	this.runningHeadRuleCB = element.all(by.css("[type='checkbox']")).get(5);
	this.headerPosForm = element(by.id("headerPositionInput"));
	this.runningHeaderRuleForm =  element(by.id("headerPositionRuleInput"));
	
	this.omitChapNumRunHeadCB = element.all(by.css("[type='checkbox']")).get(6);
	this.runningHeadTitleLeftForm = element(by.id("runningHeaderTitleLeftInput"));
	this.runningHeadTitleCenterForm = element(by.id("runningHeaderTitleCenterInput"));
	this.runningHeadTitleRightForm = element(by.id("runningHeaderTitleRightInput"));
	
	this.showVerseRefCB = element.all(by.css("[type='checkbox']")).get(7);
	this.omitBookRefCB = element.all(by.css("[type='checkbox']")).get(8);
	this.runningHeadevenLeftForm = element(by.id("runningHeaderEvenLeftInput"));
	this.runningHeadevenCenterForm = element(by.id("runningHeaderEvenCenterInput"));

	this.runningHeadevenRightForm = element(by.id("runningHeaderEvenRightInput"));
	this.runningHeadOddLeftForm = element(by.id("runningHeaderOddLeftInput"));
	this.runningHeadOddCenterForm = element(by.id("runningHeaderOddCenterInput"));
	this.runningHeadOddRightForm = element(by.id("runningHeaderOddRightInput"));


	/*
	//footer
	this.footerTab = element(by.css("[heading='Footer']"));
	
	this.runningFootCB = element.all(by.css("[type='checkbox']")).get(6);
	this.footnoteRuleCB = element.all(by.css("[type='checkbox']")).get(7);
	this.resetPageCallFootCB = element.all(by.css("[type='checkbox']")).get(8);
	this.omitCallInFoot = element.all(by.css("[type='checkbox']")).get(9);
	this.useSpecialCallFootCB = element.all(by.css("[type='checkbox']")).get(10);
	this.paragFootCB = element.all(by.css("[type='checkbox']")).get(11);
	this.useNumCallFootCB = element.all(by.css("[type='checkbox']")).get(12);
	this.footPosForm = element(by.id("footerPositionInput"));
	this.specialCallFootForm = element(by.id("specialCallerFootnotesInput"));
	
	/*
	//printer options
	this.printerOptionTab = element(by.css("[heading='Printer Options']"));
	
	//background
	this.backgroundTab = element(by.css("[heading='Background']"));
	
	//body text
	this.bodyTextTab = element(by.css("[heading='Body Text']"));
	
	//Misc
	this.miscTab = element(by.css("[heading='Misc']"));*/
	
};
module.exports = new SfProjectPage();
