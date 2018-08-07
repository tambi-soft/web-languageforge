import {browser, by, element, ExpectedConditions} from 'protractor';

import {BellowsLoginPage} from '../../../bellows/shared/login.page';
import {ProjectsPage} from '../../../bellows/shared/projects.page';
import {EditorPage} from '../shared/editor.page';

describe('Lexicon E2E Editor Comments Bubble Dialog ', async () => {
    const constants = require('../../../testConstants.json');
    const loginPage = new BellowsLoginPage();
    const projectsPage = new ProjectsPage();
    const editorPage = new EditorPage();
    const log4js = require('log4js');
    const logger = log4js.getLogger('TestprotractorLog4js');
    logger.level = 'trace';

    it('setup: login, click on test project', async () => {
        await loginPage.loginAsManager();
        await projectsPage.get();
        await projectsPage.clickOnProjectName(constants.testProjectName);
    });

    it('browse page has correct word count', async () => {
        // flaky assertion, also test/app/languageforge/lexicon/editor/e2e/editor-entry.spec.js:20
        await expect<any>(editorPage.browse.entriesList.count()).toEqual(editorPage.browse.getEntryCount());
        await expect<any>(editorPage.browse.getEntryCount()).toBe(3);
    });

    it('click on first word', async () => {
        await editorPage.browse.findEntryByLexeme(constants.testEntry1.lexeme.th.value).click();
    });

    it('click first comment bubble, type in a comment, add text to another part of the entry, ' +
        'submit comment to appear on original field', async () => {
        await editorPage.comment.bubbles.first.click();
        await editorPage.comment.newComment.textarea.sendKeys('First comment on this word.');
        await editorPage.edit.getMultiTextInputs('Definition').first().sendKeys('change value - ');
        await browser.wait(ExpectedConditions.visibilityOf(editorPage.comment.newComment.postBtn),
            constants.conditionTimeout);
        await editorPage.comment.newComment.postBtn.click();
        await editorPage.Likes.click();
        await editorPage.Todobtn.click();
        await editorPage.CommentBox.click();
        await editorPage.CommentTextArea.sendKeys('reply to earlier comment');
        await editorPage.CommentSubmit.get(0).click();
    });

    it('verify the Likes, comments and Todo', async () => {
        await editorPage.edit.toCommentsLink.click();
        const comment = editorPage.comment.getComment(0);
        await expect<any>(comment.score.getText()).toEqual('1 Like');
        browser.logger.info('Expect: 1 Like appeared');

        await expect<any>(editorPage.ToDoCheck.getText()).toEqual('To do');
        browser.logger.info('Expect: "To do" appeared');

        await editorPage.ToDoCheck.click();

        await expect<any>(editorPage.commentcount.get(0).getText()).toEqual('1 Comment');
        browser.logger.info('Expect: "1 Comment" appeared');

        await expect<any>(editorPage.replytext.get(0).getText()).toEqual('reply to earlier comment');
        browser.logger.info('Expect: "reply to earlier comment" appeared');
    });

    it('Edit the message and update', async () => {
        await editorPage.threedotbutton.click();
        await editorPage.editbutton.get(0).click();
        await editorPage.editTextArea.click();
        await editorPage.editTextArea.clear();
        await editorPage.editTextArea.sendKeys('the text modified');
        await editorPage.updatebutton.click();
    });

    it('Verify the updated message', async () => {
        await editorPage.comment.bubbles.first.click();
        await expect<any>(editorPage.resolvedCheck.getText()).toContain('Resolved');
        browser.logger.info('Expect: "Recolved" appeared with green color');
        await expect<any>(editorPage.updateText.get(0).getText()).toEqual('the text modified');
        browser.logger.info('Expect: "the text modified" appeared');
    });
});
