// @ts-nocheck
import { __ } from '@wordpress/i18n';
import { useDispatch, useSelector } from 'react-redux';
import { changeBadgeSettingProperties } from '../../../../../../features/badges/badgesSlice';
import { clipPaths } from '../../../../../../utils/badgeUtils';
import cn from '../../../../../../utils/cn';
import SectionContainer from '../../Common/SectionContainer';

const BadgeShape = () => {
  const dispatch = useDispatch();
  const { badge_settings } = useSelector((state) => state.badges);
  const handleBadgeSettingChange = (name, value) => {
    dispatch(changeBadgeSettingProperties({ name: name, value: value }));
  };

  return (
    <SectionContainer className='wmx-mt-6 wmx-mb-4' title={__('Badge Shape')}>
      <div className='wmx-flex wmx-text-center wmx-flex-wrap  wmx-justify-center wmx-gap-4'>
        {Object.keys(clipPaths).map((key) => (
          <button
            onClick={() => handleBadgeSettingChange('clipKey', key)}
            className={cn('wmx-border-2 wmx-p-2 wmx-bg-primary/5 wmx-rounded-lg wmx-border-gray-100', {
              'wmx-bg-primary/5 wmx-border-primary': String(badge_settings.clipKey) === String(key),
            })}
            dangerouslySetInnerHTML={{
              __html: `<div style='display:flex; align-items: center; justify-content: center; font-weight: 700; height: 48px; width: 120px; background: #bbb; ${
                clipPaths[key]
              }'>${String(key) === '0' ? 'None' : ''}</div>`,
            }}
          ></button>
        ))}
      </div>
    </SectionContainer>
  );
};
export default BadgeShape;
