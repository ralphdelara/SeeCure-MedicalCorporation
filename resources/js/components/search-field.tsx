import { useForm } from '@inertiajs/react';
import { IconSearch, IconX } from '@tabler/icons-react';
import { useEffect } from 'react';
import { Button } from './ui/button';
import { Input } from './ui/input';
import { Select } from './ui/select';

interface SearchProps {
    url: string;
    selectOption?: any;
}

const SearchField = ({ url, selectOption }: SearchProps) => {
    const { data, setData, get, processing } = useForm({
        keyword: '',
        selectId: '',
    });

    useEffect(() => {
        const queryParams = new URLSearchParams(window.location.search);
        setData('keyword', queryParams.get('keyword') ?? '');
        setData('selectId', queryParams.get('selectId') ?? '');
    }, [setData]);

    const search = (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();

        get(url);
    };

    const clearSearch = () => {
        setData('keyword', '');
        get(url);
    };

    const selectBy = (selectId: string) => {
        setData('keyword', '');
        setData('selectId', selectId);
        get(url);
    };

    return (
        <form name="searchForm" onSubmit={search}>
            <div className="input-group">
                <Input
                    name="keyword"
                    value={data.keyword}
                    onChange={(e) => setData('keyword', e.target.value)}
                    className="form-control form-control-lg"
                    placeholder="Enter keyword"
                />
                {data.keyword !== '' && (
                    <Button
                        variant="danger"
                        type="button"
                        onClick={() => clearSearch()}
                        disabled={processing}
                    >
                        <IconX />
                    </Button>
                )}
                {selectOption && (
                    <Select
                        value={data.selectId}
                        onChange={(e) => selectBy(e.target.value)}
                        options={selectOption.options}
                        type={selectOption.type}
                    />
                )}
                <Button variant="default" type="submit" disabled={processing}>
                    <IconSearch />
                </Button>
            </div>
        </form>
    );
};

export default SearchField;
