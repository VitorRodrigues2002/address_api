require('dotenv').config();
const path = require('path');
const puppeteer = require('puppeteer');
const d = new Date();
const fullDate = ('0' + d.getDate()).slice(-2) + ('0' + (d.getMonth() + 1)).slice(-2) + d.getFullYear();

const downloadPath = path.resolve(process.env.CTT_FOLDER_DOWNLOAD_PATH.concat(`${fullDate}`));

async function main() {
    const browser = await puppeteer.launch({ headless: false });
    const page = await browser.newPage();
    await page.goto(process.env.CTT_CSV_PATH);
    await page.type('#username', process.env.CTT_EMAIL);
    await page.type('#password', process.env.CTT_PASSWORD);
    await page.keyboard.press('Enter');

    await page._client.send('Page.setDownloadBehavior', {
        behavior: 'allow',
        downloadPath: downloadPath
    });
    try {
        await page.waitForSelector('#actionErrors');
        alert('Login Incorreto');
        browser.close();
    } catch {
        await page.goto(process.env.CTT_SITE_PATH);
    }
    browser.close()


}


main();


