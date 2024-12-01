// @ts-nocheck
import { __ } from '@wordpress/i18n';
import { useDispatch, useSelector } from 'react-redux';
import { changeBadgeSettingProperties } from '../../../../../../../features/badges/badgesSlice';
import SectionContainer from '../../../Common/SectionContainer';
import CustomPicker from './components/CustomPicker';

const BadgeColors = () => {
  const dispatch = useDispatch();
  const { badge_settings } = useSelector((state) => state.badges);

  const handleBadgeColorChange = (name, value) => {
    dispatch(changeBadgeSettingProperties({ name, value }));
  };

  const colorPickers = [
    { label: 'Background Color', key: 'background', hideControls: false },
    { label: 'Text Color', key: 'color', hideControls: true },
    { label: 'Border Color', key: 'borderColor', hideControls: true },
  ];

  return (
    <SectionContainer className='wmx-mt-6' title={__('Badge Colors')}>
      <div className='wmx-flex wmx-gap-6 wmx-items-center'>
        {colorPickers.map(({ label, key, hideControls }) => (
          <CustomPicker
            key={key}
            label={label}
            value={badge_settings[key]}
            onChange={(value) => handleBadgeColorChange(key, value)}
            hideControls={hideControls}
          />
        ))}
      </div>
    </SectionContainer>
  );
};

export default BadgeColors;
