package com.inventory.cis;

import android.app.Activity;
import android.app.Dialog;
import android.content.Context;
import android.content.Intent;
import android.content.res.Resources;
import android.graphics.Color;
import android.graphics.drawable.ColorDrawable;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.Window;
import android.view.WindowManager;
import android.view.inputmethod.InputMethodManager;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.SearchView;
import android.widget.Toast;

/*
import com.google.android.gms.appindexing.Action;
import com.google.android.gms.appindexing.AppIndex;
import com.google.android.gms.appindexing.Thing;
import com.google.android.gms.common.api.GoogleApiClient;
*/

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

/**
 * Created by Administrator on 12/15/2016.
 */

public class ViewInventoryActicity extends Activity implements OnClickListener {

    ListView listInventory;
    CustomAdapter adapter;
    public ViewInventoryActicity CustomListView = null;
    public ArrayList<ListModel> CustomListViewValuesArr = new ArrayList<ListModel>();


    EditText search;
    Button btnSearch, btnHome;
    String searchkey;
    String Response_code, result;
    Boolean error;
    JSONObject list_inventory;
    JSONObject jobj;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.view_inventory);

        init();


        CustomListView = this;
        //Resources res = getResources();
        adapter = new CustomAdapter(CustomListView, CustomListViewValuesArr, getApplicationContext());
        listInventory.setAdapter(adapter);


        getListInventory();
    }




    /******
     * Function to set data in ArrayList
     *************/
    public void setListData() {
        try {
            Log.d("test--", Response_code);
            JSONArray list_inventory = new JSONArray(Response_code);

            int arrSize = list_inventory.length();

            for (int i = 0; i < arrSize; ++i) {
                final ListModel sched = new ListModel();
                JSONObject inventory = list_inventory.getJSONObject(i);

                String img_url = StaticData.getlink(getApplicationContext()).replace("Services", "img/inventory") + Integer.toString(inventory.getInt("id")) + ".jpg";


                sched.setInventoryId(inventory.getInt("id"));
                if (!inventory.getString("part_number").equals("null") && !inventory.getString("part_number").isEmpty() )
                    sched.setInventoryPartnumber(inventory.getString("part_number"));
                if (!inventory.getString("serial_number").equals("null") && !inventory.getString("serial_number").isEmpty())
                    sched.setInventorySerialnumber(inventory.getString("serial_number"));
                sched.setInventoryRegistertime(inventory.getString("register_time"));
                sched.setInventoryRegisterUserName(inventory.getString("register_username"));
                if (!img_url.isEmpty())
                    sched.setImage(img_url);
                sched.setLocation(inventory.getString("location"));
                if (!inventory.getString("remark").isEmpty() && !inventory.getString("remark").equals("null"))
                    sched.setRemark(inventory.getString("remark"));
                sched.setDescription(inventory.getString("description"));
                sched.setQuantity(Integer.parseInt(inventory.getString("quantity")));
                CustomListViewValuesArr.add(sched);

            }


            //listInventory.setAdapter(adapter);
            //CustomListView.invalidate();

        } catch (JSONException e) {
            e.printStackTrace();
        }
 //       adapter.notifyDataSetChanged();



    }

    public void onItemClick(int mPosition) {
        ListModel tempValues = (ListModel) CustomListViewValuesArr.get(mPosition);

        Integer inventory_id = tempValues.getInventoryId();
        String part_number = tempValues.getInventoryPartnumber();
        String serial_number = tempValues.getInventorySerialnumber();
        String location = tempValues.getLocation();
        String remark = tempValues.getRemark();
        String description = tempValues.getDescription();
        String register_time = tempValues.getInventoryRegistertime();
        String register_user = tempValues.getInventoryRegisterUserName();
        Integer quantity = tempValues.getQuantity();
        String image = tempValues.getImage();

        Intent intent = new Intent(getBaseContext(), ViewDetailInventoryActivity.class);

        intent.putExtra("inventory_id", inventory_id);
        intent.putExtra("image", image);
        intent.putExtra("part_number", part_number);
        intent.putExtra("serial_number", serial_number);
        intent.putExtra("location", location);
        intent.putExtra("remark", remark);
        intent.putExtra("description", description);
        intent.putExtra("register_time", register_time);
        intent.putExtra("register_user", register_user);
        intent.putExtra("quantity", quantity);
        startActivity(intent);

    }


    private void getListInventory() {

        if (StaticData.isNetworkConnected(getApplicationContext())) {
            try {
                new getListInventory().execute();
            } catch (Exception e) {
                //e.printStackTrace();
            }
        } else {
            Toast.makeText(getApplicationContext(),
                    "Not connected to Internet", Toast.LENGTH_SHORT)
                    .show();
        }
    }

    private void init() {
        listInventory = (ListView) findViewById(R.id.list_inventory);

        search = (EditText) findViewById(R.id.search);
        btnSearch = (Button) findViewById(R.id.btn_search);
        btnHome = (Button) findViewById(R.id.btn_back);

        btnHome.setOnClickListener(this);
        btnSearch.setOnClickListener(this);

        searchkey = "";

        this.getWindow().setSoftInputMode(WindowManager.LayoutParams.SOFT_INPUT_STATE_ALWAYS_HIDDEN);
    }


    @Override
    public void onClick(View view) {
        switch (view.getId()) {

            case R.id.btn_search:

                InputMethodManager mgr = (InputMethodManager) getSystemService(Context.INPUT_METHOD_SERVICE);
                mgr.hideSoftInputFromWindow(search.getWindowToken(), 0);

                searchkey = search.getText().toString();
                CustomListViewValuesArr.clear();
                adapter.notifyDataSetChanged();
                getListInventory();
                break;
            case R.id.btn_back:
                Intent intent = new Intent(getApplicationContext(), homeActivity.class);
                //intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                startActivity(intent);
                finish();
        }

    }

    private class getListInventory extends AsyncTask<String, Void, Void> {

        Dialog pDialog = new Dialog(ViewInventoryActicity.this);

        protected void onPreExecute() {

            pDialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
            pDialog.getWindow().setBackgroundDrawable(
                    new ColorDrawable(Color.TRANSPARENT));
            pDialog.setContentView(R.layout.custom_image_dialog);
            pDialog.show();
            pDialog.setCancelable(false);
        }

        // Call after onPreExecute method
        protected Void doInBackground(String... urls) {
            getData();
            Log.d("....", "...." + Response_code);
            return null;
        }

        protected void onPostExecute(Void unused) {

            try {
                if (pDialog.isShowing())
                    pDialog.dismiss();
                    adapter.notifyDataSetChanged();
                //Login_result();
            } catch (Exception e) {
                // TODO: handle exception
                //e.printStackTrace();
            }

        }
    }

    private void getData() {

        try {
            Log.d("data", "sent");
            JSONObject json = new JSONObject();

            json.put("searchkey", searchkey);

            String url = StaticData.getlink(getApplicationContext()) + "list_inventory.php";
            Log.d("url------", url);

            ServiceHandler sh = new ServiceHandler();

            String jsonStr = sh.makeRequest(url, ServiceHandler.POST, json.toString());
            Log.d("listView---", jsonStr);
            result = jsonStr;
        } catch (Throwable t) {
            Toast.makeText(this, "Request failed: " + t.toString(), Toast.LENGTH_LONG).show();
        }
        try {

            Response_code = result;

            setListData();
        } catch (Exception e) {
            //e.printStackTrace();
        }
    }


}
