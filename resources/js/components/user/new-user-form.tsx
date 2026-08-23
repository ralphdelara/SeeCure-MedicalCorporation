import { AddOrUpdateUserFormProps } from './new-user';
import Account from './new-user-account';
import Personal from './new-user-personal';
import Contact from './new-user-contact';

const NewUserForm = ({ data, setData, errors = {} }: AddOrUpdateUserFormProps) => {
    return (
        <section role="tabpanel" className="body current pt-0">
            <div className="form-group">(*) Mandatory</div>

            <Account data={data} setData={setData} errors={errors} />
            <Personal data={data} setData={setData} errors={errors} />
            <Contact data={data} setData={setData} errors={errors} />
        </section>
    );
};

export default NewUserForm;
