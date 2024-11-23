// @ts-nocheck
import { css } from '@codemirror/lang-css';
import { color } from '@uiw/codemirror-extensions-color';
import CodeMirror from '@uiw/react-codemirror';
import { useCallback } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import { changeBadgeSettingProperties } from '../../../../../../features/badges/badgesSlice';

function CssEditor() {
  const { badge_settings } = useSelector((state) => state.badges);
  const dispatch = useDispatch();
  const onChange = useCallback((value) => {
    dispatch(changeBadgeSettingProperties({ name: 'cssContent', value }));
  }, []);
  return (
    <>
      <p className='wmx-bg-primary/10 wmx-rounded-t-lg wmx-text-base wmx-font-semibold wmx-py-1.5 wmx-px-3'>Css</p>
      <CodeMirror
        theme='dark'
        value={badge_settings.cssContent}
        height='300px'
        extensions={[css(), color]}
        onChange={onChange}
      />
    </>
  );
}
export default CssEditor;
