// @ts-nocheck
import { ArrowUpTrayIcon } from '@heroicons/react/24/outline';
import { useDispatch } from 'react-redux';
import { changeBadgeSettingProperties } from '../../../../../features/badges/badgesSlice';

const UploadBadge = () => {
  const dispatch = useDispatch();

  const openMediaLibrary = () => {
    const mediaUploader = wp.media({
      title: 'Select or Upload Badge',
      button: {
        text: 'Select This Image',
      },
      multiple: false,
    });

    mediaUploader.on('select', () => {
      dispatch(changeBadgeSettingProperties({ name: 'type', value: 'upload' }));
      const attachment = mediaUploader.state().get('selection').first().toJSON();
      dispatch(changeBadgeSettingProperties({ name: 'uploadedUrl', value: attachment.url }));
    });

    mediaUploader.open();
  };

  return (
    <button
      className='wmx-capitalize wmx-flex wmx-gap-2 wmx-items-center wmx-rounded-lg wmx-bg-primary/10 wmx-outline-none wmx-shadow-none wmx-px-4 wmx-text-base wmx-font-semibold wmx-py-2'
      onClick={openMediaLibrary}
    >
      Upload Image <ArrowUpTrayIcon className='wmx-size-4' />
    </button>
  );
};

export default UploadBadge;
