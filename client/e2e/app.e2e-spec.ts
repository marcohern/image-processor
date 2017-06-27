import { ImageProcessorPage } from './app.po';

describe('image-processor App', () => {
  let page: ImageProcessorPage;

  beforeEach(() => {
    page = new ImageProcessorPage();
  });

  it('should display welcome message', done => {
    page.navigateTo();
    page.getParagraphText()
      .then(msg => expect(msg).toEqual('Welcome to app!!'))
      .then(done, done.fail);
  });
});
