# Default Groups
Programmatically define default groups

## Can be added to a member extension like this:

```php
class MemberExtension extends DataExtension {
  
  const APP_ADMIN_GROUP_CODE = 'app-admins';
  const APP_USER_GROUP_CODE = 'app-users';

	public function requireDefaultRecords() {
		parent::requireDefaultRecords();

		DefaultGroupsHelper::default_group(
			MemberExtension::APP_USER_GROUP_CODE, //group code
			_t('MemberExtension.AppUsers','App Users'), //group name
			null, //parent code
			null //permissions
		);
		DefaultGroupsHelper::default_group(
			MemberExtension::APP_ADMIN_GROUP_CODE, //group code
			_t('MemberExtension.AppAdministrators','App Administrators'), //group name
			MemberExtension::APP_USER_GROUP_CODE, // parent code
			//permissions:
			array(
				'APP_ACCESS_ADMIN'
			)
		);		

	}
}
```
