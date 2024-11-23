// @ts-nocheck
import { __ } from '@wordpress/i18n';
import PlaceHolderTip from '../../Common/PlaceHolderTip';
import SectionContainer from '../../Common/SectionContainer';
import CssEditor from './CssEditor';
import HtmlEditor from './HtmlEditor';

const CodeEditor = () => {
  return (
    <>
      <SectionContainer className='wmx-mt-6 wmx-mb-4' title={__('HTML Content')}>
        <div className='wmx-grid wmx-grid-cols-2 wmx-gap-4'>
          <div className='wmx-col-span-2 2xl:wmx-col-span-1'>
            <HtmlEditor />
          </div>
          <div className='wmx-col-span-2 2xl:wmx-col-span-1'>
            <CssEditor />
          </div>
        </div>
        <PlaceHolderTip />
      </SectionContainer>
    </>
  );
};
export default CodeEditor;
