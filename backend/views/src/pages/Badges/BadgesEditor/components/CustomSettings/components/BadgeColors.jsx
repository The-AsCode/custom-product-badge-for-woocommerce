// @ts-nocheck
import { EyeDropperIcon } from '@heroicons/react/24/solid';
import { __ } from '@wordpress/i18n';
import { useEffect, useRef, useState } from 'react';
import ColorPicker from 'react-best-gradient-color-picker';
import { useDispatch, useSelector } from 'react-redux';
import { changeBadgeSettingProperties } from '../../../../../../features/badges/badgesSlice';
import SectionContainer from '../../Common/SectionContainer';

const BadgeColors = () => {
  const dispatch = useDispatch();
  const { badge_settings } = useSelector((state) => state.badges);

  const [activePicker, setActivePicker] = useState(null);
  const colorPickerRefs = useRef({});
  const preventCloseRef = useRef(false);

  const handleBadgeColorChange = (name, value) => {
    dispatch(changeBadgeSettingProperties({ name, value }));
  };

  const handleClickOutside = (event) => {
    if (preventCloseRef.current) {
      preventCloseRef.current = false;
      return;
    }

    const isClickOutside = Object.values(colorPickerRefs.current).some((ref) => ref && !ref.contains(event.target));

    if (isClickOutside) {
      setActivePicker(null);
    }
  };

  useEffect(() => {
    document.addEventListener('mousedown', handleClickOutside);
    return () => {
      document.removeEventListener('mousedown', handleClickOutside);
    };
  }, []);

  const renderColorPickerButton = (key) => {
    return (
      <button
        id={key}
        onMouseDown={() => {
          preventCloseRef.current = true;
        }}
        onClick={() => setActivePicker(key)}
        style={{ background: badge_settings[key] }}
        className='wmx-flex wmx-justify-center wmx-bg-white wmx-size-10 wmx-rounded-full wmx-items-center'
      >
        <EyeDropperIcon className='wmx-h-5 wmx-w-5' />
      </button>
    );
  };

  const renderColorPicker = (label, key, hideControls = false) => {
    const isActive = activePicker === key;

    return (
      <div className='wmx-flex wmx-items-center wmx-gap-2'>
        <span>{__(label, 'custom-product-badge-for-woocommerce')}:</span>
        <div className='wmx-relative'>
          {renderColorPickerButton(key)}
          {isActive && (
            <div
              ref={(ref) => (colorPickerRefs.current[key] = ref)}
              className='wmx-absolute wmx-z-10 wmx-bg-[#202020] wmx-p-1.5 wmx-shadow-lg wmx-rounded-lg'
              style={{
                top: 'calc(100% + 4px)',
                left: '50%',
                transform: 'translateX(-50%)',
              }}
            >
              <ColorPicker
                hideControls={hideControls}
                className='wmx-rounded-lg'
                hidePresets
                hideAdvancedSliders
                hideColorGuide
                onChange={(value) => handleBadgeColorChange(key, value)}
                value={badge_settings[key]}
              />
            </div>
          )}
        </div>
      </div>
    );
  };

  const colorPickers = [
    { label: 'Background Color', key: 'background', hideControls: false },
    { label: 'Text Color', key: 'color', hideControls: true },
    { label: 'Border Color', key: 'borderColor', hideControls: true },
  ];

  return (
    <SectionContainer className='wmx-mt-6' title={__('Badge Colors')}>
      <div className='wmx-flex wmx-gap-6 wmx-items-center'>
        {colorPickers.map(({ label, key, hideControls }) => renderColorPicker(label, key, hideControls))}
      </div>
    </SectionContainer>
  );
};

export default BadgeColors;
