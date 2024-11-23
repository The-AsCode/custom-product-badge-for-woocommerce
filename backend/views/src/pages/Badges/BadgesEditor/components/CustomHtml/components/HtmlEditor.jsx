// @ts-nocheck
import { html } from '@codemirror/lang-html';
import CodeMirror from '@uiw/react-codemirror';
import { useCallback } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import { changeBadgeSettingProperties } from '../../../../../../features/badges/badgesSlice';

function HtmlEditor() {
  const { badge_settings } = useSelector((state) => state.badges);
  const dispatch = useDispatch();
  const onChange = useCallback((value) => {
    dispatch(changeBadgeSettingProperties({ name: 'htmlContent', value }));
  }, []);
  return (
    <>
      <p className='wmx-bg-primary/10 wmx-rounded-t-lg wmx-text-base wmx-font-semibold wmx-py-1.5 wmx-px-3'>HTML</p>
      <CodeMirror
        theme='dark'
        value={badge_settings.htmlContent}
        height='300px'
        extensions={[html({ autoCloseTags: true })]}
        onChange={onChange}
      />
    </>
  );
}
export default HtmlEditor;
